CREATE or REPLACE FUNCTION safety_rates_save() RETURNS trigger AS $$
DECLARE

  c_contractor_id INTEGER = NULL;
  c_year INTEGER = NULL;
  c_question_id INTEGER = NULL;

  m_question_id INTEGER = NULL;
  w_question_id INTEGER = NULL;
  e_question_id INTEGER = NULL;

  m_value FLOAT = NULL;
  w_value FLOAT = NULL;
  ans FLOAT = NULL;


BEGIN

  SELECT id INTO m_question_id FROM questions WHERE safety_type = 'M';
  SELECT id INTO w_question_id FROM questions WHERE safety_type = 'W';
  SELECT id INTO e_question_id FROM questions WHERE safety_type = 'E';

  IF (TG_OP = 'INSERT') THEN
    c_contractor_id = NEW.contractor_id;
    c_year = NEW.year;
    c_question_id = NEW.question_id;
  ELSIF (TG_OP = 'UPDATE') THEN
    c_contractor_id = OLD.contractor_id;
    c_year = OLD.year;
    c_question_id = OLD.question_id;
  END IF;
  /*EMR*/
  IF (c_question_id = e_question_id ) then
    perform * FROM safety_rates WHERE type = 'EMR' AND year = c_year AND contractor_id = c_contractor_id;

    IF not found THEN
      INSERT INTO safety_rates (answer,type, year, contractor_id, created, modified)
      VALUES (CAST(NEW.answer AS FLOAT),'EMR',c_year,c_contractor_id,NOW(),NOW());
    ELSE
      UPDATE safety_rates SET answer = CAST(NEW.answer AS FLOAT), modified = NOW() WHERE type= 'EMR' AND year = c_year AND contractor_id = c_contractor_id;
    END IF;
  /*TRIR*/
  ELSIF (c_question_id = m_question_id or c_question_id = w_question_id) then

    SELECT CAST(answer AS FLOAT) INTO m_value FROM contractor_answers
    WHERE answer != '' AND question_id = m_question_id AND contractor_id = c_contractor_id AND year = c_year;

    SELECT CAST(answer AS FLOAT) INTO w_value FROM contractor_answers
    WHERE answer != '' AND question_id = w_question_id AND contractor_id = c_contractor_id AND year = c_year;
    IF (m_value IS NOT NULL and w IS NOT null) then
      ans = (m_value*200000)/w_value;
      ans = ROUND(ans::numeric,2);

      perform * FROM safety_rates WHERE type= 'TRIR' AND year = c_year AND contractor_id = c_contractor_id;

      IF not found THEN
        INSERT INTO safety_rates (answer,type, year, contractor_id, created, modified)
        VALUES (ans,'TRIR',c_year,c_contractor_id,NOW(),NOW());
      ELSE
        UPDATE safety_rates SET answer = ans, modified = NOW() WHERE type= 'TRIR' AND year = c_year AND contractor_id = c_contractor_id;
      END IF;
    ELSE
      DELETE FROM safety_rates WHERE type= 'TRIR' AND year = c_year AND contractor_id = c_contractor_id;
    END IF;

  END IF;

  RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER safety_rates_trigger
  AFTER INSERT OR UPDATE ON contractor_answers
  FOR EACH ROW EXECUTE PROCEDURE safety_rates_save();