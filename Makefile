
build:
	docker build --pull -t nanawel/lbtr .

push:
	docker push nanawel/lbtr

up:
	docker run --rm -p 8080:8080 nanawel/lbtr