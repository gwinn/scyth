# Scyth

Various encryption tools


### PBKDF2

This class can encrypt data with a pure PHP PBKDF2 implementation.
It takes a data string and encryption password to encrypt the data.
The class uses a pure PHP implementation of PBKDF2 to create a new key from the password. 
The resulting key is used to actually encrypt the data.
The encrypted data may optionally be encoded using base64.
The class can also decrypt previously encrypted data also using the PBKDF2 of the encryption.
The encryption algorithm and block mode are configurable parameters.

### Caesar

This class which implements simple cipher, also known as Caesar's cipher, 
the shift cipher, Caesar's code or Caesar shift, is one of the simplest and most 
widely known encryption techniques. It is a type of substitution cipher in which 
each letter in the plaintext is replaced by a letter some fixed number of positions 
down the alphabet. For example, with a left shift of 3, D would be replaced 
by A, E would become B, and so on. The method is named after Julius Caesar, 
who used it in his private correspondence.

