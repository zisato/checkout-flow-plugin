FROM php:7.1-fpm

RUN apt update && \
    apt full-upgrade -y && \
    apt install -y curl wget git nano libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12-dev libicu-dev libicu52

RUN curl -sLS https://deb.nodesource.com/setup_8.x | bash - && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt update && \
    apt install -y nodejs yarn

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install iconv && \
    docker-php-ext-install exif && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd && \
    docker-php-ext-install zip

# Install java, Xvfb, x11vnc server and firefox
# Download Selenium Standalone Server
# Remove supervisord configs for nginx and php - we don't need to run them in this container
# (but we need PHP configuration to run Behat tests)
#--RUN \
#--  apt-get install -y openjdk-7-jre-headless time xvfb x11vnc supervisor

#--RUN  curl -sSL -o /usr/bin/selenium-server-standalone.jar http://selenium-release.storage.googleapis.com/2.45/selenium-server-standalone-2.45.0.jar

# grab latest google chrome
#--RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -
#--RUN echo "deb http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list
#--RUN apt-get update && apt-get install -y google-chrome-stable unzip

#--RUN    dbus-uuidgen > /etc/machine-id

# Chrome Driver
#--RUN curl -sSL -o /root/chromedriver_linux64.zip https://chromedriver.storage.googleapis.com/2.8/chromedriver_linux64.zip && \
#--    cd /root ; unzip chromedriver_linux64.zip && rm chromedriver_linux64.zip && mv chromedriver /usr/bin && chmod 755 /usr/bin/chromedriver

# ----
#RUN rm -f /opt/google/chrome/chrome-sandbox
#RUN wget https://googledrive.com/host/0B5VlNZ_Rvdw6NTJoZDBSVy1ZdkE -O /opt/google/chrome/chrome-sandbox
#--RUN chown root:root /opt/google/chrome/chrome-sandbox && chmod 4755 /opt/google/chrome/chrome-sandbox && md5sum /opt/google/chrome/chrome-sandbox
#

COPY php.ini /usr/local/etc/php/conf.d/
COPY default.conf /usr/local/etc/php-fpm.d/www.conf

RUN usermod -u 1000 www-data

EXPOSE 4444
