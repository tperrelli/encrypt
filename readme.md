# Encrypt
## _A simple library to Encrypt and Decrypt PHP messages_

Encrypt is a simple library that provides a smart way to encrypt and decrypt php messages,
according to the choosen algorithm.

## Installation
`composer install tperrelli/encrypt`

## Usage

### Encrypt
`$hashed = Encrypt::encrypt('public message');`

### Decrypt
`$public = Encrypt::decrypt($hashed);`

## License

[MIT](https://opensource.org/licenses/MIT)