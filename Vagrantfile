# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
	config.vm.hostname = "dev.checkbusca.com"
	config.vm.box = "ubuntu/trusty32"
	config.vm.network "public_network"
	config.vm.box_check_update = false
	config.vm.provision :shell, path: "bootstrap.sh"	  
	config.vm.provider "virtualbox" do |virtualbox|
		virtualbox.customize [ "modifyvm", :id, "--cpus", "1" ]
		virtualbox.customize [ "modifyvm", :id, "--memory", "600" ]
	end
end