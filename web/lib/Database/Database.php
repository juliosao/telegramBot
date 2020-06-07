<?php

namespace Database;

use \PDO;
use Exceptions\DatabaseException;

/**
 * \class Database
 * \brief Clase manejadora de la base de datos
 */
class Database {    
   
    static $instancia; /**< Aqui guardamos la instancia creada de la clase, solo puede haber una a la vez */
    static $initialized=false;


	/**
	 * \fn __construct($path, $usr = null, $passw = null)
	 * \brief Class constructor
	 */
    function __construct($path = null, $usr = null, $passw = null) 
    {
        try
        {
            $this->db = new PDO($path,$usr,$passw,
                    array( PDO::ATTR_PERSISTENT => true )
                    );

        
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            throw new DatabaseException($ex->getMessage());
        }

    }

    /**
     * \fn __destruct()
     * \brief Disconnects database 
     */
    function __destruct() {
        $this->db = null;
    }


    /**
     * \fn consultar($consulta,&$campos=-1,$pagina=-1)
     * \brief Executes query
     * \param $consulta Cadena con la consulta a ejecutar
     * \param $campos Array asociativo con los parametros a pasar a la consulta
     * 
     * Dentro de la consulta podemos usar el caracter '?' para indicar un parametro de $campos (Se buscará por posición)
     * o bien :nombreCampo para indicarlo (En este caso se buscara la clave 'nombreCampo'		
     */
    function query($consulta, $campos = array(),$className=null,$ctorArgs=array()) 
    {	
        try
        {
            $stm = $this->db->prepare($consulta);
            if($className!==null)
                $stm->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $className, $ctorArgs);                    

            $stm->execute($campos);
            $res=$stm->fetchAll();
            $stm->closeCursor();
            return $res;
        }
        catch(\Exception $ex)
        {
            throw new DatabaseException($ex->getMessage());
        }

    }
    
    /**
     * \fn execute($consulta,&$campos=-1,$pagina=-1)
     * \brief ejecuta una consulta en la base de datos y retorna el numero de filas afectadas
     * \param $consulta Cadena con la consulta a ejecutar
     * \param $campos Array asociativo con los parametros a pasar a la consulta
     * 
     * Dentro de la consulta podemos usar el caracter '?' para indicar un parametro de $campos (Se buscará por posición)
     * o bien :nombreCampo para indicarlo (En este caso se buscara la clave 'nombreCampo'		
     */
    function execute($consulta, $campos = array()) 
    {	
        try
        {
            $stm = $this->db->prepare($consulta);
            $stm->execute($campos);
            $res=$stm->rowCount();	
            $stm->closeCursor();
            return $res;
        }
        catch(\Exception $ex)
        {
            throw new DatabaseException($ex->getMessage());
        }
    }

	/**
	 * \fn getInsertId()
	 * \brief Devuelve el ID de la ultima fila insertada (su clave autonumerica)
	 */
    function getInsertId() 
    {
        return $this->db->lastInsertId();
    }
}

