<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscriptionPassagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscriptionPassagesTable Test Case
 */
class InscriptionPassagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InscriptionPassagesTable
     */
    public $InscriptionPassages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inscription_passages',
        'app.passages',
        'app.licencies',
        'app.clubs',
        'app.regions',
        'app.inscription_competitions',
        'app.grades',
        'app.equipes',
        'app.categories',
        'app.competitions',
        'app.categories_competitions',
        'app.disciplines',
        'app.users',
        'app.grade_presentes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('InscriptionPassages') ? [] : ['className' => 'App\Model\Table\InscriptionPassagesTable'];
        $this->InscriptionPassages = TableRegistry::get('InscriptionPassages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InscriptionPassages);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
