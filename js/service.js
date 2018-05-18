(function() {

    angular.module('app')
        .factory('ClientService',serviceFactory);
    serviceFactory.$inject = ['$http'];

    function serviceFactory($http) {

        var genders = [
            {value: '1', label: 'Мужской'},
            {value: '2', label: 'Женский'}
        ];

        function find(phone, lastName) {
            if (!phone) {
                phone = '';
            }
            if (!lastName) {
                lastName = '';
            }
            return $http.get('/api.php?action=find&phone='+phone+'&lastName='+lastName)
                .then(function(resp) {
                    angular.forEach(resp.data, function(item) {
                        if (item.gender == 1) {
                            item.gender = genders[0];
                        } else {
                            item.gender = genders[1];
                        }
                    });
                    return resp.data;
                });
        }

        function insert(client) {
            return $http.post('/api.php?action=insert', client);
        }

        function update(client) {
            return $http.post('/api.php?action=update', client);
        }

        function remove(client) {
            return $http.post('/api.php?action=delete', client);
        }

        return {
            find: find,
            insert: insert,
            update: update,
            remove: remove,
            genders: genders
        };




    }

})()