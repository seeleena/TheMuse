<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockBuilder;

class DatabaseConnectionTest extends TestCase{

    // Test case to verify retrieving an existing database connection
    public function testGetCoreDBLink() {
        // Mock the global variable $dbCoreLink
        require_once './lib/dbConnection.php';

        $GLOBALS['dbCoreLink'] = [];

        // Define a mock connection
        $mockConnection = $this->getMockBuilder(mysqli::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        // Add the mock connection to $dbCoreLink
        $GLOBALS['dbCoreLink']['test_link'] = $mockConnection;

        // Call the function to be tested
        $result = get_CoreDB_link('test_link');

        // Assert that the function returns the mock connection
        $this->assertSame($mockConnection, $result);
    }

    public function testGetCoreDBLinkEstablishesNewConnection() {
        require_once './lib/dbConnection.php';
        
        // Mock the global variable $dbCoreLink
        $GLOBALS['dbCoreLink'] = [];

        // Define a mock connection
        $mockConnection = $this->getMockBuilder(mysqli::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        // Mock the establish_CoreDB_link function to return the mock connection
        !$this->getMockBuilder('stdClass')
             ->addMethods(['establish_CoreDB_link'])
             ->getMock()
             ->expects($this->once())
             ->method('establish_CoreDB_link')
             ->with('test_link')
             ->willReturn($mockConnection);

        // Call the function to be tested
        $result = get_CoreDB_link('test_link');

        // Assert that the function returns the mock connection
        $this->assertSame($mockConnection, $result);
    }

}