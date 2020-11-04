<?php
/**
* @package   lizmap
* @subpackage pgmetadata
* @author    Pierre DRILLIN
* @copyright 2020 3liz
* @link      https://3liz.com
* @license    Mozilla Public Licence
*/

class search {

  protected $sql = array(
    'check_dataset' => "SELECT tablename FROM pg_tables WHERE schemaname = 'pgmetadata' AND tablename = 'dataset'",
    'get_html'=>'SELECT pgmetadata.get_dataset_item_html_content($1, $2) AS html'
  );

  protected function getSql($option) {
      if(isset($this->sql[$option])){
        return $this->sql[$option];
      }
      return Null;
  }

  function query( $sql, $filterParams, $profile='pgmetadata' ) {
      $cnx = jDb::getConnection( $profile );
      $resultset = $cnx->prepare( $sql );
      if(empty($filterParams)){
        $resultset->execute();
      }else{
        $resultset->execute( $filterParams );
      }
      return $resultset;
  }

  /**
  * Get PDF generated by QGIS Server Cadastre plugin
  * @param project Project key
  * @param repository Repository key
  * @param geom Geometry as WKT
  * @param srid Cordiante system identifier
  */

  function getData($profile, $filterParams, $option) {
        // Run query
        $sql = $this->getSql($option);
        if(!$sql){
            return Null;
        }
        return $this->query( $sql, $filterParams, $profile );
    }
}
?>
