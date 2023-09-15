Let's Build That Response
=========================

Simple echo service that builds a HTTP response according to the provided GET params.

Inspired by <https://www.params.org>

## Run

```shell
docker run --rm -p 8080:8080 -d nanawel/lbtr
```

Then, from your HTTP client, use `header` to define headers and `body` to provide the body (as a URL-compatible base64 string).

## Simple example

> The `-g` flag is needed to make `curl` ignore the brackets used for the `header` parameter.

```shell
curl -vg 'http://localhost:8080/?header[Content-Type]=application/json&body=ewogICJuYW1lIiA6IkpvaG4gRG9lIiwKICAiZW1haWwiOiJqb2huLmRvZUBleGFtcGxlLmNvbSIsCn0'
* processing: http://localhost:8080/?header[Content-Type]=application/json&body=ewogICJuYW1lIiA6IkpvaG4gRG9lIiwKICAiZW1haWwiOiJqb2huLmRvZUBleGFtcGxlLmNvbSIsCn0
*   Trying [::1]:8080...
* Connected to localhost (::1) port 8080
> GET /?header[Content-Type]=application/json&body=ewogICJuYW1lIiA6IkpvaG4gRG9lIiwKICAiZW1haWwiOiJqb2huLmRvZUBleGFtcGxlLmNvbSIsCn0 HTTP/1.1
> Host: localhost:8080
> User-Agent: curl/8.2.1
> Accept: */*
> 
< HTTP/1.1 200 OK
< Host: localhost:8080
< Date: Thu, 14 Sep 2023 14:30:30 GMT
< Connection: close
< Content-Type: application/json
< 
{
  "name" :"John Doe",
  "email":"john.doe@example.com",
}
* Closing connection
```

## Exemple using multiple **decoders** for the body

With the parameter `dec` in the URL you can tell LBTR to process the body with multiple decoders among:

- `base64_url_decode` (default when the `dec` parameter is not present)
- `base64_decode`
- `zlib_decode`
- `gzinflate`
- `json_prettify`
- `print` (does not do anything)
- `echo` (does not do anything)
- `none` (does not do anything)

[Analyze the following example with Cyberchef](https://gchq.github.io/CyberChef/#recipe=From_Base64('A-Za-z0-9-_',true,false)Gunzip()JSON_Beautify('%20%20%20%20',false,true)&input=SDRzSUFJWlBCR1VBX3czSU1RcUFNQXlGNGF1RWY1WWVvSk9EazdjSS1rQ2xhUndGOGU1MV9WNjZoN0RLbWtlM0pjV0V3czlHNWZxcDdLbFpqOGZkVkxZTXZnRU80dEJOTXdBQUFB)

```shell
curl -vg 'http://localhost:8080/?header[Content-Type]=application/json&body=H4sIAIZPBGUA_w3IMQqAMAyF4auEf5YeoJODk7cI-kClaRwF8e51_V66h7DKmke3JcWEws9G5fqp7KlZj8fdVLYMvgEO4tBNMwAAAA&dec=base64_url_decode,zlib_decode,json_prettify,print'
*   Trying 127.0.0.1:8080...
* Connected to localhost (127.0.0.1) port 8080
> GET /?header[Content-Type]=application/json&body=H4sIAIZPBGUA_w3IMQqAMAyF4auEf5YeoJODk7cI-kClaRwF8e51_V66h7DKmke3JcWEws9G5fqp7KlZj8fdVLYMvgEO4tBNMwAAAA&dec=base64_url_decode,zlib_decode,json_prettify,print HTTP/1.1
> Host: localhost:8080
> User-Agent: curl/8.2.1
> Accept: */*
> 
< HTTP/1.1 200 OK
< Host: localhost:8080
< Date: Fri, 15 Sep 2023 12:35:44 GMT
< Connection: close
< Content-Type: application/json
< 
{
    "name": "John Doe",
    "email": "john.doe@example.com"
}
* Closing connection
```