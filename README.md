## Heroku

### Deploying with Git

```
heroku login
heroku create
git push heroku master
```

### Deploying with Docker

```
heroku login
heroku create
heroku container:login
heroku container:push web
heroku labs:enable runtime-new-layer-extract
heroku container:release web
```
