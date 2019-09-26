# Type Annotations

### Mapper\Annotation\StringType
Accepts string or null

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\BooleanType
Accepts boolean or null

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\IntegerType
Accepts integer or null

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\FloatType
Accepts float or null

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\ObjectType
Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
 * **class** – require class name implementing `Mapper\ModelInterface`

### Mapper\Annotation\CollectionType
Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
 * **type** – require type annotation

### Mapper\Annotation\DateTimeType
Accepts string with format or null, converts to \DateTime

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\DateType
Accepts string with format or null, converts to \DateTime

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
    
### Mapper\Annotation\TimestampType
Accepts integer or null, converts to \DateTime

Options:
 * **nullable** – is null allowed, if option not specified value will be fetched from settings
