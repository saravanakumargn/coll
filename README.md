
Run server
```
php bin/console server:run
```

Clean cache
```
php bin/console cache:clear
```

Seters and Getters
```
php bin/console doctrine:generate:entities AppBundle/Entity/Product
```

CRUD
```
php bin/console generate:doctrine:crud --entity=DataAdminBundle:Post  --with-write
```

Directly update database
```
php bin/console doctrine:schema:update --force
```