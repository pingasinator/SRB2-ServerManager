# SRB2-ServerManager
a web interface for managing your dedicated srb2 servers

## dependencies

- apache
- php
- php-zip
- flatpak
- flathub
- srb2's flatpak
- tmux

## Installation

1. 

```shell
    sudo apt install apache2 php php-zip flatpak tmux sudo
    sudo flatpak remote-add --if-not-exists flathub https://dl.flathub.org/repo/flathub.flatpakrepo
    sudo flatpak install org.srb2.SRB2
```

2. make the user "www-data" a sudoer

```shell
    sudo echo 'www-data ALL=(ALL) NOPASSWD: ALL' >> /etc/sudoers
    sudo chown www-data:www-data -R /var/www/html/SRB2-ServerManager
```

3. in the php.ini file, make sure that "upload_max_filesize" and "post_max_size" are at least 200MB

4. go into the html folder and clone the repo
```shell
  cd /var/www/html/
  sudo git clone https://github.com/pingasinator/SRB2-ServerManager.git
```
