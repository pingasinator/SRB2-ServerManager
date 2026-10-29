# SRB2-ServerManager

A web interface for managing your dedicated [Sonic Robo Blast 2](https://www.srb2.org/) servers.

**Features:** start/restart/kill the server, change map, gametype and limits, force a character, live console, addon upload, player and ban management, broadcast messages.

## Requirements

Apache, PHP (with the zip extension), Flatpak (with Flathub and `org.srb2.SRB2`), tmux, sudo and git.

## Installation

### 1. Install the dependencies

| Distribution | Command |
|---|---|
| Debian / Ubuntu | `sudo apt install apache2 php php-zip flatpak tmux sudo git` |
| Fedora / RHEL | `sudo dnf install httpd php php-zip flatpak tmux sudo git` |
| Arch | `sudo pacman -S apache php php-apache flatpak tmux sudo git` |

Then install SRB2:

```shell
sudo flatpak remote-add --if-not-exists flathub https://dl.flathub.org/repo/flathub.flatpakrepo
sudo flatpak install flathub org.srb2.SRB2
```

### 2. Download the project

```shell
cd /var/www/html/
sudo git clone https://github.com/pingasinator/SRB2-ServerManager.git
sudo chown -R www-data:www-data SRB2-ServerManager
```

### 3. Allow the web server to use sudo

```shell
echo 'www-data ALL=(ALL) NOPASSWD: ALL' | sudo tee /etc/sudoers.d/srb2-servermanager
sudo chmod 440 /etc/sudoers.d/srb2-servermanager
```

The panel runs its commands as root through `sudo` (see [Security](#security)).

### 4. Raise the PHP upload limits

In `php.ini`, set both values to at least 200 MB:

```ini
upload_max_filesize = 200M
post_max_size = 200M
```

### 5. Restart Apache

```shell
sudo systemctl restart apache2
```

Then open `http://<your-server-ip>/SRB2-ServerManager/`.

> **Other distributions:** replace `www-data` with `apache` (Fedora / RHEL) or `http` (Arch), and `apache2` with `httpd`. On Arch the web root is `/srv/http`.

## Security

The panel runs with root privileges, so anyone who can use it controls the machine. Never expose it directly to the internet: put it behind a VPN, or at least protect it with a password (Apache basic auth over HTTPS) and an IP restriction.

## Troubleshooting

- **Addon upload fails:** check that `upload_max_filesize` and `post_max_size` are at least 200M, then restart Apache.
- **Nothing happens when clicking buttons:** check that the sudoers file is valid (`sudo visudo -c`) and that `www-data` owns the project folder.
