<?php

    namespace Eceon\MVC\Controller;

    use Eceon\Request\InterfaceRequest;
    use Eceon\MVC\Model\Service\InterfaceService; 
    use Eceon\MVC\View\InterfaceView;
    
    /**
     * Generated by PHPUnit_SkeletonGenerator on 2015-08-19 at 15:39:41.
     */
    class AbstractControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var AbstractController
         */
        protected $object;

        /**
         * Sets up the fixture, for example, opens a network connection.
         * This method is called before a test is executed.
         */
        protected function setUp()
        {
            $this->object = $this->getMockForAbstractClass( AbstractController::class );
        }


        public function testUncallableAction()
        {
            // create an unknown action
            $action_name = 'unknow_action_name';

            // we expect an exception to be thrown, action_name is not a method
            $this->setExpectedException('exception' );

            $new_request = $this->getMockBuilder( InterfaceRequest::class )
                                ->getMock();
            
            // call unknown action
            $this->object->execute( $action_name, $new_request );        
        }

        public function testCallAction()
        {
            // create an unknown action
            $action_name = 'test';

            // build an request object
            $new_request = $this->getMockBuilder( InterfaceRequest::class )
                                ->getMock();
            
            // call unknown action
            $this->assertNull( $this->object->execute( $action_name, $new_request ) );        
        }



        public function testMagicCallHelper()
        {
            // create new (mock) helper object
            $new_helper = $this->getMockBuilder( Helper\InterfaceHelper::class )
                                ->getMock();
            $new_helper->method( 'helper' )->will( $this->returnValue(true) );

            // add mock object to controller
            $this->object->addHelper( 'test_helper', $new_helper );

            // call helper mock object, should return true
            $this->assertTrue( $this->object->__call( 'test_helper', array() ) );
        }

        public function testMagicCallUnknownHelper()
        {
            // create an unknown helper name
            $helper_name = 'unknow_helper_name';

            // we expect an exception to be thrown, helper_name is not set
            $this->setExpectedException('exception', 'ControllerHelper ' .$helper_name . ' not found!' );

            // call unknown helper name
            $this->object->__call( $helper_name, array() );

        }


        public function testAddAndGetHelper()
        {
            $new_helper = $this->getMockBuilder( Helper\InterfaceHelper::class )
                                ->getMock();

            $this->object->addHelper( 'test_helper', $new_helper );

            $this->assertSame( $new_helper, $this->object->getHelper('test_helper') );
            $this->assertSame( $new_helper, $this->object->helper('test_helper') );

            $this->assertInstanceOf( Helper\InterfaceHelper::Class, $this->object->getHelper('test_helper') );
        }

        public function testGetUnknowHelper()
        {
            $helper_name = 'unknow_helper_name';

            $this->assertNull( $this->object->getHelper( $helper_name ) );
        }


        public function testAddAndGetService()
        {
            $new_service = $this->getMockBuilder( InterfaceService::class )
                                ->getMock();

            $this->object->addService( 'test_service', $new_service );

            $this->assertSame( $new_service, $this->object->getService( 'test_service' ) );

            $this->assertInstanceOf( InterfaceService::class, $this->object->getService('test_service') );
        }


        public function testGetUnknownService()
        {
            $service_name = 'unknow_service_name';

            $this->assertNull( $this->object->getService( $service_name ) );
        }



        public function testAddAndGetView()
        {
            $new_view = $this->getMockBuilder( InterfaceView::class )
                             ->getMock();


            $this->assertNull( $this->object->getView() );

            $this->object->setView( $new_view );

            $this->assertSame( $new_view, $this->object->getView() );
            $this->assertSame( $new_view, $this->object->view() );

            $this->assertInstanceOf( InterfaceView::class, $this->object->getView() );
        }


    }