1.0.1
------
- Fixed deprecated return types and calls

0.11.2
------
- Fixed deprecated return types and calls

0.11.1
------
- Fixed mixed return value in PHP 7.4 (with ReturnTypeWillChange Attribute)

0.11.0
------
- Added PHP 8.1 compatibility

0.10.2
------
- Added PHP 8.0 compatibility

0.10.1
------
- No need for PHP 7.4. Back to PHP >= 7.1

0.10.0
------
- Pushed to PHP >= 7.4
- Implemented IteratorAggregate on PropertyCollection
- Changed Cast method. Null values will not be casted

0.9.0
-----
- Fixed assoc arrays
- Fixed __toString Method

0.8.0
-----
- Fixed missing property on empty Arrays

0.7.3
-----
- Added additional toArray check

0.7.2
-----
- Optional getter and setter have been added

0.7.1
-----
- Fixed missing Trait Class

0.7.0
-----
- Implemented ArrayAccess Interface to Model

0.6.0
-----
- Fixed a bug in toArray method

0.5.2
-----
- Added case insensitive property name support

0.5.1
-----
- Fixed some Warnings

0.5.0
-----
- Changed serialized datetime format from ATOM to RFC3339_EXTENDED

0.4.2
-----
- Added __toString method to model class

0.4.1
-----
- Added Serializable interface to model class

0.4.0
-----
- Added DateTime serialization format

0.3.1
-----
- Minor serializer fix

0.3.0
-----
- Renamed snake case array key disabler

0.2.1
-----
- Added additional getter / setter logic tests
- Added snake case array key disabler

0.2.0
-----
- Fixed preg match and getter logic

0.1.5
-----
- Added preg match to remove 'isIsFoobar' getter

0.1.4
-----
- Fixed Model serialization

0.1.3
-----
- Fixed date check

0.1.2
-----
- Fixed date check
- Removed utf8 encoding enforcement while string casting

0.1.1
-----
- Added Unit Tests 
- Added new PropertyCollection Array Constructor

0.1.0
-----
- Push to release state

0.0.1
-----
- Added core features
