# postcodes-ng-website
A Site showcasing Nigeria postcode lookup proof of concept

## Development
### Dependencies
* Ensure php 8.1.* is installed. You can check the php version by running `php -v`.
* [Docker Desktop](https://www.docker.com/products/docker-desktop) - make sure to install Docker Desktop.
* For Windows users ensure that Windows Subsystem for Linux 2 ([WSL2](https://learn.microsoft.com/en-us/windows/wsl/install)) is installed and enabled.

### Running Locally
* git clone this repository
* cd into the `postcodes-ng-website` folder
* Create an env file using the env.example template ==> `cat .env.example > .env` and update it with the necessary details or contact team lead for content on the file.
* Install the application's dependencies by running the following command
    ```shell
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```
* Configure a shell alias for the `sail` command. To do this add the below line to your shell configuration file (such as `~/.zshrc` or `~/.bashrc`) and then restart your terminal.
    `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`
* Run `sail up`. This creates the docker container for the project if run the first time.
* Run `sail npm ci`
* Run `sail npm run watch-poll`
* Once it's up, browse to `http://localhost:80/`