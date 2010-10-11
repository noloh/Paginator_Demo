<?php
/**
* Paginator Example 1
* A NOLOH Paginator example demonstrating it's basic usage
*/

//Include NOLOH
require_once('/PATH/TO/NOLOH');
//Basic WebPage class, serves as application starting point
class Paginator1 extends WebPage
{
	//Class Constructor triggered by NOLOH 
	function Paginator1()
	{
		parent::WebPage('Basic Usage of Paginator');
		//Create Data::$Link to Demo databases
		Data::$Links->DB1 = new DataConnection(Data::Postgres, 'demo_1', 'demo_1');
		//object where our paginated results will show
		$resultsPanel = new Panel(10, 50, 200, 300);
		$resultsPanel->BackColor = Color::Bisque;
		//Then we construct our Paginator and pass in $resultsPanel
 		$pages = new Paginator($resultsPanel, 10, 30);
  		//Create the DataCommand we want to page through
		$command = Data::$Links->DB1->CreateCommand(Data::SQL, 'SELECT * FROM persons');
		/*we then Bind the Paginator to the newly created $command
		 * and set the callback for each row of data. We also set
		 * a limit of 8 results per page*/
 		 $pages->Bind($command, new ServerEvent($this, 'CreatePerson'), 8);
 		 //Add Controls to the WebPage's Controls. Shows the Controls.
		 $this->Controls->AddRange($pages, $resultsPanel);
	}
	/**
	* Our CreatePerson function, used as the callback in our paginator
	*/
	function CreatePerson()
	{
	    //The data for each row of data is stored in Event::$BoundData
	    $person = Event::$BoundData;
	    $name = new Label($person['firstname'] . ' ' . $person['lastname']);
	    //Style the $name, making it a bit prettier
	    $name->SetSize('100%', null);
	    $name->CSSBorderBottom = '1px dotted black';
	    $name->CSSPadding = '5px';
	    //Set Label's Layout to Relative
	    $name->Layout = Layout::Relative;
	    //Set a Click for each $name
	    $name->Click = new ServerEvent('System', 'Alert', "person_id for {$name->Text} is {$person['person_id']}.");
	    /*We must return an object for each callback. Paginator will automatically
	      add this object to your results panel. You can return ANY object that 
	      extends Control*/
	    return $name;	
	}
}
?>