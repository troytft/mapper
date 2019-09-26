# Type Annotations

### Mapper\Annotation\StringType
Accepts string

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\BooleanType
Accepts boolean

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\IntegerType
Accepts integer

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\FloatType
Accepts float

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\ObjectType
Accepts array with data and map to model, specified by option class

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
 * **class** – require class name implementing `Mapper\ModelInterface`

### Mapper\Annotation\CollectionType
Accepts collection with item type, specified by option type

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
 * **type** – require type annotation

### Mapper\Annotation\DateTimeType
Accepts string with format, converts to \DateTime

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\DateType
Accepts string with format, converts to \DateTime

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\TimestampType
Accepts integer, converts to \DateTime

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
