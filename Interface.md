# Web API directory
```
i/
```

## Data (backup)

#### Pull all data (export backup) (get all)
```
i/pull
```

#### Push data (import backup) (add)
```
i/push
```

## User

#### pull all users (get all)
```
i/user/pull
```

#### pull params
```
i/user/pull?name=$
```

#### push user (add)
```
i/user/push/?name$
```

## Provider

Providers (Aka fornecedores) are owners of products

#### pull all providers (get all)
```
i/provider/pull
```

#### pull params
```
i/provider/pull?name=$
```

#### push provider (add)
```
i/provider/push/?name$
```

## Category

### Category Push

#### pull all categories (get all)
```
i/category/pull
```

#### pull params
```
i/category/pull?_id=$
i/category/pull?name=$
```

### Category Pull

#### push category (add)
```
i/category/push/?name=$
```

## Product

### Product Push

#### pull all products (get all)
```
i/product/pull
```

#### pull params
```
i/product/pull?_id=$
i/product/pull?name=$
```

### Product Pull

#### push product (add)
```
i/product/push/?name=$&code=$&provider_id=$&category_id=$
```

#### push product (add)
```
i/product/push/?_id=$&name=$&code=$&provider_id=$&category_id=$
```

## Product Relationships

Product relationships group all product with same name (or similar)

### Relationship Push

#### pull all relationships (get all)
```
i/productRelationship/pull
```

#### pull params
```
i/productRelationship/pull?product_id=$
i/productRelationship/pull?relationship_id=$
```

### Relationship Pull

#### push relationship (add)
```
i/relationship/push/
```

#### push some product to relationship (add)
```
i/productRelationship/push/?relationship_id=$?product_id=$
```