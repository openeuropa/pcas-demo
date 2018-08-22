# Demo pCAS library

## Demo

The demo contains two independent Symfony applications:

* demo-client: A basic web app that can authenticate to a CAS server to access specific pages.
* demo-server: A basic CAS server.

In order to test pCAS library, you must set these applications locally.

### Step 1: Git

Clone the repository.

### Step 2: Docker

Copy the `docker-compose.yml.dist` file into `docker-compose.yml`. You can make
alterations, however the defaults should be enough.

Run the `docker-compose up -d`

### Step 3: Composer

Install the composer dependencies of the applications:

```
docker-compose exec pcas-client composer install
docker-compose exec pcas-server composer install
```

### Step 3: Hosts

Inside your machine's hosts file, map your localhost (`127.0.0.1`) to the following host: `pcas-server`.:

```
127.0.0.1      pcas-server
```

Now, the two applications will be running at:

* Client: http://localhost:8081/demo-client/public
* Server: http://pcas-server:8080/demo-server/public

You can also test it against ECAS, the authentication service from European Commission by updating the file ```.env``` in
```demo-client``` directory. If this file does not exist, you can create it from ```.env.dist```.

The file must contains:

```
APP_ENV=ec
```