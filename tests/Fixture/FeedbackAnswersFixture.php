<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FeedbackAnswersFixture
 *
 */
class FeedbackAnswersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'contractor_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'feedback_question_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'answer' => ['type' => 'text', 'length' => null, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'fki_contractor_fk1' => ['type' => 'index', 'columns' => ['contractor_id'], 'length' => []],
            'fki_feedback_question_fk' => ['type' => 'index', 'columns' => ['feedback_question_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'contractor_fk' => ['type' => 'foreign', 'columns' => ['contractor_id'], 'references' => ['contractors', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'contractor_fk1' => ['type' => 'foreign', 'columns' => ['contractor_id'], 'references' => ['contractors', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'feedback_question_fk' => ['type' => 'foreign', 'columns' => ['feedback_question_id'], 'references' => ['feedback_questions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'contractor_id' => 1,
                'feedback_question_id' => 1,
                'answer' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
