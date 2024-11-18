sudo dnf install -y epel-release

sudo dnf install -y git python3-pip python3-virtualenv

sudo dnf -y install dnf-plugins-core
sudo dnf config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo

sudo dnf install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

sudo systemctl enable --now docker

sudo groupadd docker

sudo usermod -aG docker $USER
