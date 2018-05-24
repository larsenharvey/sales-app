<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_sales extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'sales';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
        ),
        'quantity' => array(
            'type'       => 'BIGINT',
            'null'       => false,
        ),
        'price' => array(
            'type'       => 'BIGINT',
            'null'       => false,
        ),
        'description' => array(
            'type'       => 'VARCHAR',
            'constraint' => 256,
            'null'       => false,
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}