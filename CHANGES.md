# Release History

## 0.6.1
- add `Entitlement` class that is an exact copy of `Scope` with all occurences
  of `Scope` replaced by `Entitlement` and `scope` by `entitlement`. In the
  future there needs to be a better way...

## 0.6.0
- add TokenIntrospection class (use by `php-oauth-lib-rs` and `php-lib-rest`)
- no longer use `ScopeException`, but use `InvalidArgumentException` from PHP 
  SPL instead

## 0.5.0
* rename package to fkooman/oauth-common

## 0.4.2
* Allow specifying a string separator in `Scope::toString()` and 
  `Scope::fromString()` instead of just the default space

## 0.4.1
* Allow `null` as parameter to `Scope::fromString()`

## 0.4.0
* Deduplicate and sort scope tokens at object creation
* Reintroduce some older deprecated API methods, `isSubsetOf()`, `getToken()` 
  and `getTokenAsArray()`

## 0.3.3
* Allow empty string as parameter to `Scope::fromString`

## 0.3.2
* Add `Scope::hasOnlyScope`
* Add documentation, see `docs/SCOPES.md`

## 0.3.1
* Introduce `Scope::fromString`

## 0.3.0
* New API
** remove `compareTo()` returning 0, -1 and -1
** add `equals()` returning true or false

## 0.2.0
* New API
** only accept array as constructor parameter
** introduce `toArray()`, `toString()` and `__toString()`

## 0.1.0
* Initial release
