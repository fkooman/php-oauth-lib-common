# Introduction
This document describes the rationale behind the handling of OAuth scopes and
describes the methods.

## hasScope
This method verifies that the object that this method is called on contains 
the scopes in the parameter scope.

    $scope = new Scope(array("foo", "bar"));
    $scope->hasScope(new Scope(array("foo")));

This call returns `true` as the `$scope` object has scope `foo`.

## hasAnyScope
This method is similar to `hasScope`, but allowes any of the scopes in the 
parameter as satisfying the requirement.

    $scope = new Scope(array("foo", "bar"));
    $scope->hasAnyScope(new Scope(array("foo", "foobar")));

This returns `true` as `$scope` has the scope `foo`. If this same example would
be used with `hasScope` it would return `false` as the scope `foobar` is not 
part of `$scope`.

## hasOnlyScope
This method checks for a subset. The object that this method is called on needs
to contain only scopes that are part of the parameter scope and nothing extra.

    $scope = new Scope(array("foo", "bar"));
    $scope->hasOnlyScope(new Scope(array("foo", "bar", "baz")));

This returns `true` as `foo` and `bar` are both part of the parameter scope.

    $scope->hasOnlyScope(new Scope(array("foo")));

This returns `false` as `bar` is no longer contained in the parameter scope.
