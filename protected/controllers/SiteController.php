<?php

class SiteController extends CController {
	
	public function actionIndex() {
		$this->render('index');
	}

	public function actionTree() {
        $data = $this->getDataFormatted($this->getData());
        $this->render('tree', array('data'=>$data));
	}

    public function actionTreeFill() {
        if ( ! isset($_GET['root']))
            $personId = 'source';
        else
            $personId = $_GET['root'];

        $persons = ($personId == 'source') ?
			$this->getData() : $this->recursiveSearch($personId, $this->getData());

		$dataTree = array();
        if (is_array($persons)) {
            foreach($persons as $parent)
                $dataTree[] = $this->formatData($parent);
        }
        echo json_encode($dataTree);
//        echo CTreeView::saveDataAsJson($dataTree);
    }

	protected function recursiveSearch($id, $rootnode) {
       if (is_array($rootnode)) {
            foreach($rootnode as $person) {
                if ($person['id'] == $id)
                    return $person["parents"];
                else {
                    $r = $this->recursiveSearch($id, $person["parents"]);
                    if ($r !== null)
                         return $r;
				}
			}
		}
		return null;
    }

    protected function formatData($person) {
      return array(
		  'text'=>$person['name'],
		  'id'=>$person['id'],
		  'hasChildren'=>isset($person['parents']));
    }

    protected function getDataFormatted($data) {
        foreach($data as $k=>$person) {
            $personFormatted[$k] = $this->formatData($person);
            $parents = null;
            if (isset($person['parents'])) {
                $parents = $this->getDataFormatted($person['parents']);
                $personFormatted[$k]['children'] = $parents;
            }
        }
        return $personFormatted;
    }

	protected function getData() {
		$data = array(
			array("id"=>1, "name"=>"John",
				"parents"=>array(
					array("id"=>10, "name"=>"Mary",
						"parents"=>array(
							array("id"=>100, "name"=>"Jane",
								"parents"=>array(
									array("id"=>1000, "name"=>"Helene"),
									array("id"=>1001, "name"=>"Peter")
								)
							),
							array("id"=>101, "name"=>"Richard",
								"parents"=>array(
									array("id"=>1010, "name"=>"Lisa"),
									array("id"=>1011, "name"=>"William")
								)
							),
						),
					),
					array("id"=>11, "name"=>"Derek",
						"parents"=>array(
							array("id"=>110, "name"=>"Julia"),
							array("id"=>111, "name"=>"Christian",
								"parents"=>array(
									array("id"=>1110, "name"=>"Deborah"),
									array("id"=>1111, "name"=>"Marc"),
								),
							),
						),
					),
				),
			),
		);
        return $data;
    }
}
