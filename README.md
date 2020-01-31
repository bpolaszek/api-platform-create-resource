This bundle is an add-on to [API Platform](https://api-platform.com/) that brings resource creation [through the PUT verb](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.6).

Kind of _upsert_ in REST.

This means you can send the following request:

```
PUT /api/books/d9a5551f-f188-45e4-a034-00b744a08a31
Content-Type: application/ld+json
Accept: application/ld+json

{"name":  "Book title"}
```

If `/api/books/d9a5551f-f188-45e4-a034-00b744a08a31` doesn't exist, this resource will be created,
otherwise its content will be replaced; as of the specification.

This way, your client doesn't have to care whether or not it should POST or PUT, it always PUTs.
This involves that you delegate the resource ID generation to the client side (which may be done with [UUIDs](https://github.com/ramsey/uuid) / [ULIDs](https://github.com/bpolaszek/doctrine-ulid) for example).

## Installation

```bash
composer require bentools/api-platform-create-resource:0.1.*
```

**Important notice:** This bundle must be loaded **before** `ApiPlatformBundle` to work properly.

## Configuration

Resource classes which expect this behavior must be explicitely listed:

```bash
# config/packages/api_platform_create_resource.yaml
api_platform_create_resource:
  allowed_classes:
    App\Entity\Book: ~
```

## Resource instanciation

If your entity/object needs a factory service to instanciate it,
you can implement your own `BenTools\ApiPlatform\CreateResource\Factory\ItemFactoryInterface` and reference it as a service:

```bash
# config/packages/api_platform_create_resource.yaml
api_platform_create_resource:
  allowed_classes:
    App\Entity\Book: '@App\Services\BookFactory'
```

## Tests

Who cares? 😄

## License

MIT.
