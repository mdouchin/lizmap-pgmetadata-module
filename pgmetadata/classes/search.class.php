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
    'idvoie'=>'SQL Query'
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

      $resultset->execute( $filterParams );
      return $resultset;
  }

  /**
  * Get PDF generated by QGIS Server Cadastre plugin
  * @param project Project key
  * @param repository Repository key
  * @param geom Geometry as WKT
  * @param srid Cordiante system identifier
  */

  function getData($repository, $project, $layer, $filterParams, $option) {

        $profile = pgmetadataProfile::get($repository, $project, $layer);
        $this->repository = $repository;
        $this->project = $project;

        // Run query
        $sql = $this->getSql($option);
        if(!$sql){
            return Null;
        }
        return $this->query( $sql, $filterParams, $profile );
    }
}
?>
