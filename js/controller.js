(function() {

    angular.module('app').controller('ClientController', clientController);
    clientController.$inject = ['ClientService'];

    function clientController(clientService) {
        var vm = this;
        vm.genders = clientService.genders;
        vm.clients = null;
        vm.currentItem = null;
        vm.mode = null;
        vm.edit = edit;
        vm.remove = remove;
        vm.add = add;
        vm.save = save;
        vm.addPhone = addPhone;
        vm.removePhone = removePhone;
        vm.searchPhone = '';
        vm.searchLastName = '';
        vm.search = search;


        clientService.find()
            .then(function(data) {
                vm.clients = data;
            });

        function edit(client) {
            vm.currentItem = {
                id: client.id,
                firstName: client.firstName,
                lastName: client.lastName,
                patronymic: client.patronymic,
                birthdate: client.birthdate,
                gender: client.gender,
                phones: []
            };
            vm.originalItem = client;
            angular.forEach(client.phones, function(phone) {
                vm.currentItem.phones.push(phone);
            });
            vm.mode = 'edit';
            $('#edit-area').modal(); // лучше бы это в директиву, но лениво
        }

        function add() {
            vm.currentItem = {
                firstName: '',
                lastName: '',
                patronymic: '',
                birthdate: '',
                gender: vm.genders[0],
                phones: []
            }
            vm.mode = 'add';
            $('#edit-area').modal();
        }

        function save() {
            if (vm.mode === 'add') {
                clientService.insert(vm.currentItem)
                    .then(function() {
                        vm.clients.push(vm.currentItem);
                        $('#edit-area').modal('hide');
                    });
            }
            if (vm.mode === 'edit') {
                clientService.update(vm.currentItem)
                    .then(function() {
                        vm.originalItem.firstName = vm.currentItem.firstName;
                        vm.originalItem.lastName = vm.currentItem.lastName;
                        vm.originalItem.patronymic = vm.currentItem.patronymic;
                        vm.originalItem.birthdate = vm.currentItem.birthdate;
                        vm.originalItem.gender = vm.currentItem.gender;
                        vm.originalItem.phones = vm.currentItem.phones;

                        $('#edit-area').modal('hide');
                    });

            }
        }

        function remove(client) {
            clientService.remove(client);
            angular.forEach(vm.clients, function(v, k) {
                if (client === v) {
                    vm.clients.splice(k, 1);
                }
            });

        }

        function addPhone() {
            vm.currentItem.phones.push({value: ''});
        }

        function removePhone(phone) {
            angular.forEach(vm.currentItem.phones, function(currentPhone, key) {
                if (currentPhone === phone) {
                    vm.currentItem.phones.splice(key, 1);
                }
            });
        }

        function search() {
            clientService.find(vm.searchPhone, vm.searchLastName)
                .then(function(data) {
                    vm.clients = data;
                });

        }





    }


})()