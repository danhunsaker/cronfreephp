<?php	defined('BASEPATH') or exit('No direct access allowed - RUN ME FROM THE APP!');

class Migration_Demo_db extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 160,
			),
			'location' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
			),
			'note' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('checkins');
	}
	
	public function down()
	{
		$this->dbforge->drop_table('checkins');
	}
}
