# osc-orm
This is a little orm or query Builder for PHP MySql. This is update for the small project not need most query to the database.

# Requierment
  - PHP 7.3
  - MySql 5.8
  - Composer

# Installation
 - with composer
    ```shell
            $ composer require faso-dev/osc-orm
# Use cases
  - We need to add the autoload file in your application entry point

    ```php
        require_once __DIR__.'/vendor/autoload.php';
  - INSERT USE
    - ### With QUERY INSERT BUILDER

      ```php
            use FSDV\Builder\QueryInsertBuilder;
            use FSDV\Persistance\ConnectionFactory;
            //if we have setting config dir in your project root
            // and it contain file named db_config.ini
            $conection = (new ConnectionFactory)
                              ->setConfig([
                                  'driver'    => 'mysql',
                                  'database'  => 'application_db',
                                  'host'      => '127.0.0.1',
                                  'username'  => 'root',
                                  'password'  => 'secret'
                              ])
                              ->create();

            $builder = new QueryInsertBuilder();
            // Build a sql query, just generate the query
            $query = $builder
                ->insertInTo('user')
                ->culums('name','username','mail','role')
                ->values('faso-dev','faso-dev','mail@mail.faso-dev','ROLE_SUPER_ADMIN')
                ->getQuery()
                ->getSQLQuery();

            // Build and commit the query on the database
            // We must give the conection instance to the query class to commit
            // query in the database
            $lastInsertId = $builder
                ->insertInTo('user')
                ->culums('name','username','mail','role')
                ->values('faso-dev','faso-dev','mail@mail.faso-dev','ROLE_SUPER_ADMIN')
                ->getQuery()
                ->setConnection($conection)
                ->save();

  - SELECT CASE
    - ### WITH QUERY SELECT BUILDER
      ```php
            use FSDV\Builder\SelectBuilder;
            $builer = new SelectBuilder();
            try {
                // select max(user_id) as last_user;
                $query = $builer->max('user_id','last_user')->from('user')->getQuery()->getSQLQuery();
                var_dump($query);
                // select count(user_id) as count_user;
                $query = $builer->count('user_id','count_user')->from('user')->getQuery()->getSQLQuery();
                var_dump($query);
                 // select count(user_id) as total;
                $query = $builer->avg('panier_price','total')->from('user')->getQuery()->getSQLQuery();
                var_dump($query);
                 // select count(user_id) as somme;
                $query =$builer->sum('panier_price','somme')->from('user')->getQuery()->getSQLQuery();
                var_dump($query);
                $query = $builer->select()
                    ->from('user','post')
                    ->where('user.id = post.user_id and post.title LIKE %:title%')
                    ->setParameter('title', 'Mon super article')
                    ->orderByAsc(['user.nom'])->getQuery()->getSQLQuery();
                var_dump($query);
                $query = $builer->select()
                    ->from('user')
                    ->lefJoin('post', 'post.user_id = user.id')
                    ->where('post.title LIKE %:title%')
                    ->setParameter('title', 'Mon super article')
                    ->orderByDesc(['user.nom'])->getQuery()->getSQLQuery();
                var_dump($query);
                $query = $builer->select('username','mail','adresse')
                    ->from('user')
                    ->avg('achat')
                    ->groupBy('username','mail','adresse')
                    ->orderByAsc(['user.username'])->getQuery()->getSQLQuery();
                ;
                var_dump($query);
                $query = $builer->select('username','mail','adresse')
                    ->from('user')
                    ->paginate(200)
                    ->orderByDesc(['user.mail'])->getQuery()->getSQLQuery();
                ;
                var_dump($query);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
  - UPDATE CASE
    - ### WITH QUERY UPDATE BUILDER
        ```php

            use FSDV\Builder\QueryUpdateBuilder;

            // build an update query
            $builder = new QueryUpdateBuilder();
            try {
                $query = $builder->update('user')
                    ->setCulums('name', 'lastname')
                    ->values('daniel', 'onadja')
                    ->where('(user.id = :user_id) OR (user.username = :username)')
                    ->setParameters([
                        'user_id'  => 1,
                        'username' => 'faso-dev',
                    ])
                    ->getQuery();
                //return sql string query
                $sql = $query->getSQLQuery();
                var_dump($sql);
                //execute the query
                $query->update();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
  - DELETE CASE
    - ### WITH QUERY DELETE BUILDER
        ```php
            use FSDV\Builder\QueryDeleteBuilder;
            //build delete query
            $builer = new QueryDeleteBuilder();
            try {
                $query = $builer->deleteFrom('user')
                    ->where('user_id = :id and (username = :username or email = :mail)')
                    ->setParameters([
                        'id'       => 1,
                        'username' => 'faso-dev',
                        'mail'     => 'faso-dev@gmail.com',
                    ])
                    ->getQuery();
                //return sql string query
                $sql = $query->getSQLQuery();
                var_dump($sql);
                //execute the query
                $query->delete();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
