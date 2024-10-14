<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClientEmployeeQuestionsFixture
 *
 */
class ClientEmployeeQuestionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'client_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'employee_question_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'is_compulsory' => ['type' => 'boolean', 'length' => null, 'default' => 0, 'null' => true, 'comment' => null, 'precision' => null],
        'correct_answer' => ['type' => 'string', 'length' => 155, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'created_by' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'modified_by' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'employee_category_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fki_clients_fkey' => ['type' => 'index', 'columns' => ['client_id'], 'length' => []],
            'fki_employee_questions_fkey1' => ['type' => 'index', 'columns' => ['employee_question_id'], 'length' => []],
            'fki_employee_categories_fkey1' => ['type' => 'index', 'columns' => ['employee_category_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'clients_fkey' => ['type' => 'foreign', 'columns' => ['client_id'], 'references' => ['clients', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'employee_categories_fkey' => ['type' => 'foreign', 'columns' => ['employee_category_id'], 'references' => ['employee_categories', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'employee_categories_fkey1' => ['type' => 'foreign', 'columns' => ['employee_category_id'], 'references' => ['employee_categories', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'employee_questions_fkey' => ['type' => 'foreign', 'columns' => ['employee_question_id'], 'references' => ['employee_questions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'client_id' => 1,
                'employee_question_id' => 1,
                'is_compulsory' => 1,
                'correct_answer' => 'Lorem ipsum dolor sit amet',
                'created' => 1587544434,
                'modified' => 1587544434,
                'created_by' => 1,
                'modified_by' => 1,
                'employee_category_id' => 1
            ],
        ];
        parent::init();
    }
}
