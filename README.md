# osc-orm
This is a little orm or query Builder for PHP MySql. This is update for the small project not need most query to the database.

# Requierment
  - PHP 7.3
  - MySql 5.8
  - Composer

# Use case
  - INSERT USE
    - ### With query builder

      ```php
      ```php
            
            use FSDV\Builder\QueryInsertBuilder;
            use FSDV\Persistance\ConnectionFactory;
            
            $conection = Persistance::getConnection();
            $builder = new QueryInsertBuilder();
    
            // Build a sql query, just generate the query 
            $query = $builder
                ->insertInTo('user')
                ->colums('name','username','mail','role')
                ->values('faso-dev','faso-dev','mail@mail.faso-dev','ROLE_SUPER_ADMIN')
                ->getQuery()
                ->getSQLQuery();
    
            // Build and commit the query on the database
            // We must give the conection instance to the query class to commit 
            // query in the database
            $lastInsertId = $builder
                ->insertInTo('user')
                ->colums('name','username','mail','role')
                ->values('faso-dev','faso-dev','mail@mail.faso-dev','ROLE_SUPER_ADMIN')
                ->getQuery()
                ->setConnection($conection)
                ->save();
                
      - SELECT CASE
  - SELECT CASE
    - ### With query builder
      ```php
        use FSDV\Builder\QueryBuilder;
        use FSDV\Persistance\Persistance;
        
        $conection = Persistance::getConnection();
        //Instance of the builder
        $builer  = new QueryBuilder($conection);

        // Return an associative array of result
        $results = $builer
            ->select()
            ->from('user')
            ->getQuery()
            ->getArrayAssocResult();

        // Return an array of result
        $results = $builer
            ->select()
            ->from('user')
            ->getQuery()
            ->getArrayResult();
