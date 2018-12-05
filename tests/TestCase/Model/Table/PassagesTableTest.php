<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PassagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PassagesTable Test Case
 */
class PassagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PassagesTable
     */
    public $Passages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.passages',
        'app.disciplines',
        'app.evenements',
        'app.competitions',
        'app.categories',
        'app.inscription_competitions',
        'app.licencies',
        'app.clubs',
        'app.regions',
        'app.grades',
        'app.users',
        'app.equipes',
        'app.categories_competitions',
        'app.inscription_passages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Passages') ? [] : ['className' => 'App\Model\Table\PassagesTable'];
        $this->Passages = TableRegistry::get('Passages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Passages);

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
