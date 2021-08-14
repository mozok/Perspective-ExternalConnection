# Perspective ExternalConnection

## Intro

This module is a demonstration of how to connect several databases to Magento 2

## 0. Connection configuration
You need to set all external connections inside env.php config file (see docs/env.php.sample).

Add new `connection` and `resource` elements.

```
'connection' => [
    'external_db1' => [
        'host' => 'localhost',
        'dbname' => 'external1',
        'username' => 'external1',
        'password' => 'external1',
        'model' => 'mysql4',
        'engine' => 'innodb',
        'initStatements' => 'SET NAMES utf8;',
        'active' => '1',
        'driver_options' => [
        1014 => false
    ]
]
...
'resource' => [
    'external_connection1' => [
        'connection' => 'external_db1'
    ]
]
```
## 1. Single entity configuration
If needed just a simple external connection for single entity, one could just adjust corresponding resource model.
```
<type name="Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity">
    <arguments>
        <argument name="connectionName" xsi:type="string">external_db1</argument>
    </arguments>
</type>
```

Where `connectionName` argument equals `connection` element from `resource` node in `env.php` configuration file.

## 2. Many entities configuration
If one need several external collection, I suggest to use Factory Method.

Create Resource for every external `connection` using `virtualType`
```
<virtualType name="\Db1\ResourceModel\ExternalEntity"
             type="Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity">
    <arguments>
        <argument name="connectionName" xsi:type="string">external_db1</argument>
    </arguments>
</virtualType>

<virtualType name="\Db2\ResourceModel\ExternalEntity"
             type="Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity">
    <arguments>
        <argument name="connectionName" xsi:type="string">external_db2</argument>
    </arguments>
</virtualType>
```

Prepare Repositories for every entity and every `connection` using `virtualType`
```
<virtualType name="\Db1\Api\ExternalEntityRepositoryInterface"
             type="Perspective\ExternalConnection\Model\ExternalEntityRepository">
    <arguments>
        <argument name="resource" xsi:type="string">\Db1\ResourceModel\ExternalEntity</argument>
    </arguments>
</virtualType>

<virtualType name="\Db2\Api\ExternalEntityRepositoryInterface"
             type="Perspective\ExternalConnection\Model\ExternalEntityRepository">
    <arguments>
        <argument name="resource" xsi:type="string">\Db2\ResourceModel\ExternalEntity</argument>
    </arguments>
</virtualType>
```

Prepare Factory for Repositories
```
<type name="Perspective\ExternalConnection\Model\ExternalEntityRepositoryFactory">
    <arguments>
        <argument name="instanceNames" xsi:type="array">
            <item name="db1" xsi:type="string">\Db1\Api\ExternalEntityRepositoryInterface</item>
            <item name="db2" xsi:type="string">\Db2\Api\ExternalEntityRepositoryInterface</item>
        </argument>
    </arguments>
</type>
```

See usage example in `\Perspective\ExternalConnection\Console\Command\ExternalConnection`

## 3. Get data from non MySQL DB

Magento Resource Models use `\Magento\Framework\DB\Adapter\AdapterInterface` to establish connection to database.
Now Magento Framework has only Mysql implementation.

But one could use `\Zend_Db` to establish connections to different DBMS.
For example to load data from MsSQL DB:
- add connection data to `env.php` (see docs/env.php.sample)
```
'db' => [
    'connection' => [
        'default' => [...]
        'sqlsrv' => [
            'host' => '',
            'dbname' => 'dotnet_db',
            'username' => 'SA',
            'password' => 'YourStrongPassw0rd'
        ]
    ]
]
```
- load configuration using `Magento\Framework\App\DeploymentConfig`
```
$connectionData = $this->deploymentConfig->get('db/connection/sqlsrv');
```
- create `\Zend_Db_Adapter_Sqlsrv`
```
$dbAdapter = $this->mssqlAdapterFactory->factory('Sqlsrv', $connectionData);
```
- use `$dbAdapter` to load needed data
```
$select = $dbAdapter->select()->from(
            ['Table'],
            ['FieldID', 'DataField', 'LinkField']
    );

$data = $dbAdapter->fetchAll($select);
```
- using `$dbAdapter` one can load all rows or filter by condition
```
$select = $dbAdapter->select()
    ->from(...)
    ->where('LinkField = ?', $linkFieldId);

$data = $dbAdapter->fetchAll($select);
```
- or load just one row
```
$dataRow = $dbAdapter->fetchRow($select);
```

For example see `\Perspective\ExternalConnection\Console\Command\SclsrvConnection`
