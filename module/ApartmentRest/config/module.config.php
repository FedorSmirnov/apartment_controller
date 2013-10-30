<?php
return array (
		
		'controllers' => array (
				
				'invokables' => array (
						
						'ApartmentRest\Controller\ApartmentRest' => 'ApartmentRest\Controller\ApartmentRestController' 
				) 
		),
		
		'view_manager' => array (
				
				'template_path_stack' => array (
						
						'apartment_rest' => __DIR__ . '/../view' 
				) 
		),
		
		'router' => array (
				
				'routes' => array (
						
						'apartment-rest' => array (
								
								'type' => 'segment',
								'options' => array (
										
										'route' => '/apartment-rest[/:id]',
										
										'defaults' => array (
												
												'controller' => 'ApartmentRest\Controller\ApartmentRest' 
										) 
								) 
						) 
				)
				 
		)
		 
);

?>