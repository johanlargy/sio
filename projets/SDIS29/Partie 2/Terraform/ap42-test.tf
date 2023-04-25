resource "proxmox_vm_qemu" "ap42-test" {
  name        = "ap42-test"
  os_type     = "cloudinit"
  desc        = "Serveur AP42 Test"
  target_node = "pxlab1"  # la machine Proxmox cible
  clone       = "Debian-11.6-Template" # le nom de la template a cloner
  cores       = 1
  sockets     = 1
  memory      = 2048

  ipconfig0 = "ip=dhcp" # ou bien ip=dhcp
  ssh_user  = "debian" # le compte SSH de connexion par défaut

  sshkeys = <<-EOT
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDG9U+GADoQOB8OVfySPtrhluiM9aVVzhvoY9XbZ+R0JO0GpasJ9+vn/I2aTEHL0AW8PUzdK0Z/Ut2ezqUcufYxYQWOMtbJYyeDiHXGToWIz9udiutb6fKQdUF62d5n55JE165QDNc9wm7CaJgyZIGDq45M+pvEPiKppdSwT3QjSjUcvPlC75VAnaROBF0H9TtfOtnLbni67A4vAQAStI141Lfn2URXKUVpbpwtozuS571dvfIdU69EQ+ZlI/nr5BTv1z2jDl2Y1mP3GdLmQtRqRVhi+z3l3BWQu5e5XnYIqp9HjuEGr95HL+K78IvsCuemlYqX8BSfit3Q4mX6w3OipPuKtoCSJb8eHiI9gKGbK7CRzEJ3GGKUg4eRTLnLr80znZAbsXHMwi6OcOOuJ4hD+ur14SQYTHJlSNm1SudJNg2pPMxOePUXFwBgb+Ixs/svvAob+4KNUwm2XHlLX29ZCZ4nQuPvjawyk9LN2vZACnvuu3GRoi5Q4PVge3wn8Pk= louis.depres@lab213-41
EOT

  network {
    model  = "virtio"
    bridge = "vmbr0"  # le bridge standard pour l'interface reseau
  }

disk {
    type         = "scsi"
    storage      = "local-lvm"
    size         = "15G"
    format       = "raw"
  }
}
