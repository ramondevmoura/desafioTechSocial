# Use a imagem PHP oficial como base
FROM php:8.2-apache

# Define o diretório de trabalho dentro do contêiner
WORKDIR /var/www/html

# Copia os arquivos do código-fonte para o contêiner
COPY backend/ /var/www/html

# Instala as extensões do PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Define as variáveis de ambiente para configuração do Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_DIR /var/log/apache2

# Copia o arquivo de configuração do VirtualHost do Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Expõe a porta 80 do contêiner
EXPOSE 80

# Comando padrão para iniciar o servidor Apache
CMD ["apache2-foreground"]