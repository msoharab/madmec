<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Timemanagement_Form_Projects extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		//$this->setAttrib('action',BASE_URL.'timemanagement/projects/edit');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'projects');


        $id = new Zend_Form_Element_Hidden('id');
        $invoice_method = new Zend_Form_Element_Hidden('invoice_method');
		
		$project_name = new Zend_Form_Element_Text('project_name');
        $project_name->setAttrib('maxLength', 100);
        
        $project_name->setRequired(true);
        $project_name->addValidator('NotEmpty', false, array('messages' => 'Please enter project name.'));
		$project_name->addValidator("regex",true,array(
									'pattern'=> '/^(?![0-9]*$)[a-zA-Z0-9.,&\(\)\/\-_\' ?]+$/',
								    'messages'=>array(
									     'regexNotMatch'=>'Please enter a valid project name.'
								     )
					       ));	
        $project_name->addValidator(new Zend_Validate_Db_NoRecordExists(
                                              array('table'=>'tm_projects',
                                                     'field'=>'project_name',
                                                     'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('id').'" and is_active=1',    
                                                 ) )  
                                    );
        $project_name->getValidator('Db_NoRecordExists')->setMessage('Project name already exists.');

        $projstatus = new Zend_Form_Element_Select('project_status');
		$projstatus->addMultiOption('','Select Status');
		$projstatus->addMultiOption('initiated','Initiated');
		$projstatus->addMultiOption('draft','Draft');
		$projstatus->addMultiOption('in-progress','In Progress');
		$projstatus->addMultiOption('hold','Hold');
		$projstatus->addMultiOption('completed','Completed');
		$projstatus->setRequired(true);
		$projstatus->setRegisterInArrayValidator(false);
		$projstatus->addValidator('NotEmpty', false, array(
			'messages' => 'Please select status.'
		));
		
		$base_project = new Zend_Form_Element_Select('base_project');
		$base_project->addMultiOption('','Select Project');
		$base_project->setRegisterInArrayValidator(false);	
       
		$client = new Zend_Form_Element_Select('client_id');
		$client->addMultiOption('','Select Client');
		$client->setRegisterInArrayValidator(false);	
        $client->setRequired(true);
        $client->addValidator('NotEmpty', false, array('messages' => 'Please select client.'));
         
		$client->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'tm_clients',
                                        		'field' => 'id',
                                                'exclude'=>'is_active = 1',
										)));
		$client->getValidator('Db_RecordExists')->setMessage('Selected client is inactivated.');
			
		$description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('rows', 10);
        $description->setAttrib('cols', 50);
		$description ->setAttrib('maxlength', '500');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');
		$this->addElements(array($id,$invoice_method,$project_name,$projstatus,$base_project,$description,$client,$submit));
         $this->setElementDecorators(array('ViewHelper')); 
          $this->setElementDecorators(array(
                    'UiWidgetElement',
        ),array('start_date','end_date'));  
	}
}