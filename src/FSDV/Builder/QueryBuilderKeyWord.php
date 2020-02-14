<?php


namespace FSDV\Builder;


class QueryBuilderKeyWord
{
    public const SELECT       = 'SELECT';
    public const INSERT       = 'INSERT INTO';
    public const VALUES       = 'VALUES';
    public const DELETE       = 'DELETE';
    public const UPDATE       = 'UPDATE';
    public const FROM         = 'FROM';
    public const WHERE        = 'WHERE';
    public const AND          = 'AND';
    public const OR           = 'OR';
    public const NATURALJOIN  = 'NATURAL JOIN';
    public const LEFTJOIN     = 'LEFT JOIN';
    public const RIGHTJOIN    = 'RIGHT JOIN';
    public const INNERJOIN    = 'INNER JOIN';
    public const SET          = 'SET';
    public const SUM          =  'SUM';
    public const AVG          =  'AVG';
    public const COUNT        =  'COUNT';
    public const MAX          =  'MAX';
    public const MIN          =  'MIN';
    public const ON           =  'ON';
    public const LIMIT        =  'LIMIT';
    public const OFSET        =  'OFSET';
    public const GROUP_BY     =  'GROUP BY';
    public const ORDER_BY     =  'ORDER BY' ;
    public const ASC          =  'ASC' ;
    public const DESC         =  'DESC' ;
}
