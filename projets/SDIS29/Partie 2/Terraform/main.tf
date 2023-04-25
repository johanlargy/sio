provider "proxmox" {
  pm_api_url          = "https://pxlab1.sio.lan:8006/api2/json"
#  pm_api_token_id     = "<user-id>"
#  pm_api_token_secret = "<secret key>"
  pm_user = "root@pam"
  pm_password = "Azerty1+"
  pm_tls_insecure     = true
  pm_debug            = true
}


variable  "pm_api_url" {
    default =  "https://pxlab1:8006/api2/json"
}

variable  "pm_user" {
    default =  "root@pam"
}

variable  "pm_password" {
    default =  "Azerty1+"
}


variable  "ssh_key" {
    default = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDG9U+GADoQOB8OVfySPtrhluiM9aVVzhvoY9XbZ+R0JO0GpasJ9+vn/I2aTEHL0AW8PUzdK0Z/Ut2ezqUcufYxYQWOMtbJYyeDiHXGToWIz9udiutb6fKQdUF62d5n55JE165QDNc9wm7CaJgyZIGDq45M+pvEPiKppdSwT3QjSjUcvPlC75VAnaROBF0H9TtfOtnLbni67A4vAQAStI141Lfn2URXKUVpbpwtozuS571dvfIdU69EQ+ZlI/nr5BTv1z2jDl2Y1mP3GdLmQtRqRVhi+z3l3BWQu5e5XnYIqp9HjuEGr95HL+K78IvsCuemlYqX8BSfit3Q4mX6w3OipPuKtoCSJb8eHiI9gKGbK7CRzEJ3GGKUg4eRTLnLr80znZAbsXHMwi6OcOOuJ4hD+ur14SQYTHJlSNm1SudJNg2pPMxOePUXFwBgb+Ixs/svvAob+4KNUwm2XHlLX29ZCZ4nQuPvjawyk9LN2vZACnvuu3GRoi5Q4PVge3wn8Pk= louis.depres@lab213-41" 
}
