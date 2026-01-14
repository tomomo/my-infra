# PHP側と同じベースイメージを採用
FROM almalinux:9-minimal

ENV TZ=Asia/Tokyo \
    TERM=xterm-256color

# Apache (httpd) と mod_ssl のインストール
# --nodocs を追加して、ここでも少しだけサイズを節約します
RUN microdnf install -y httpd mod_ssl \
    && microdnf clean all

# モジュールの有効化
RUN sed -i 's/#LoadModule rewrite_module/LoadModule rewrite_module/' /etc/httpd/conf.modules.d/00-base.conf \
    && sed -i 's/#LoadModule proxy_module/LoadModule proxy_module/' /etc/httpd/conf.modules.d/00-proxy.conf \
    && sed -i 's/#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' /etc/httpd/conf.modules.d/00-proxy.conf \
    && sed -i 's/#LoadModule http2_module/LoadModule http2_module/' /etc/httpd/conf.modules.d/00-base.conf

# デフォルト設定の削除
RUN rm -f /etc/httpd/conf.d/welcome.conf /etc/httpd/conf.d/ssl.conf

# ホストのファイル内容はビルド時に埋め込みます
RUN cat > /etc/httpd/conf.d/000-default.conf <<'EOF'
ServerTokens ProductOnly

<Directory "/app">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted

    DirectoryIndex disabled
    DirectoryIndex index.php index.html
</Directory>

RewriteEngine     On
ProxyRequests     Off
ProxyPreserveHost Off

Redirect /phpmyadmin /phpmyadmin/
<Location /phpmyadmin/>
    ProxyPass         http://phpmyadmin/
    ProxyPassReverse  http://phpmyadmin/
</Location>

Redirect /mailpit /mailpit/
<Location /mailpit/>
    ProxyPass         http://mailpit:8025/mailpit/
    ProxyPassReverse  http://mailpit:8025/mailpit/
</Location>

EOF

# タイムゾーンの設定（ログの時間などが日本時間になります）
RUN ln -snf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

WORKDIR /app
CMD ["httpd", "-D", "FOREGROUND"]
