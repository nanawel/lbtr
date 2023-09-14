Let's Build That Response
=========================

Simple echo service that builds a HTTP response according to the provided GET params.

Inspired by <https://www.params.org>

Run it with

```shell
docker run --rm -p 8080:8080 -d nanawel/lbtr
```

Then, from your HTTP client, use `header` to define headers and `body` to provide the body (as a URL-compatible base64 string).

Example:

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
< X-Powered-By: PHP/8.2.10
< Content-Type: application/json
< 
{
  "name" :"John Doe",
  "email":"john.doe@example.com",
}
* Closing connection
```