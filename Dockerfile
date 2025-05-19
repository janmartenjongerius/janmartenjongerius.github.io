# Select the PHP installation.
arg PHP_VERSION=8.3
from php:$PHP_VERSION as php_base

add --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
arg PHP_EXTENSIONS="@composer intl"
run install-php-extensions $PHP_EXTENSIONS

# Create a local develoment target.
from php_base as dev

# Set the user and group level.
arg GID=1000
arg UID=1000

# Create an app user.
run useradd -m -d /home/app -s /bin/bash app \
    && groupmod -g $GID app \
    && usermod -g $GID -u $UID app

# Create a workspace.
run mkdir /app && chown app:app /app
volume /app

# Proceed as the app user.
workdir /home/app
user app:app

# Shell
shell ["/bin/bash", "-o", "pipefail", "-c"]

# Create a script file sourced by both interactive and non-interactive bash shells
env BASH_ENV=/home/app/.bash_env
run touch "${BASH_ENV}"
run echo '. "${BASH_ENV}"' >> ~/.bashrc

# nvm
run curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | PROFILE="${BASH_ENV}" bash

# nodejs
arg NODE_VERSION=16
run nvm install $NODE_VERSION && nvm alias default $NODE_VERSION

# Set the workdir to the workspace.
workdir /app

entrypoint ["bash", "-c", "source $NVM_DIR/nvm.sh && exec \"$@\"", "--"]
cmd ["/bin/bash"]
