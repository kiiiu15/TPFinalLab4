<script type="text/javascript">
    $('#idMovie .event').on('click', function() {


        var selectValue = $(this).val();

        $.ajax({
            method: 'POST',
            url: '/TPFinalLab4/Movie/prueba',
            dataType: 'JSON',
            data: {
                selectValue
            },
            beforeSend: function() {
                // Esto ocurre al iniciar la peticion
            },
            error: function() {
                // Esto ocurre si falla
            },
            success: function(dato) {
                // Esto ocurre si la peticion al servidor se ejecuto correctamente
                var jsonContent = JSON.stringify(dato);

                var peli = JSON.parse(jsonContent);

                $('#title').text(peli.title);

            }
        });

        $.ajax({
            method: 'POST',
            url: '/TPFinalLab4/MovieFunction/prueba',
            dataType: 'JSON',
            data: {
                selectValue
            },
            beforeSend: function() {
                // Esto ocurre al iniciar la peticion
            },
            error: function() {
                // Esto ocurre si falla
            },
            success: function(dato) {
                // Esto ocurre si la peticion al servidor se ejecuto correctamente



                var jsonContent = JSON.stringify(dato);

                var array = JSON.parse(jsonContent);


                var cinemas = [];

                var cinemasId = [];

                var options = {};

                var optionsId = {};



                $.each(array, function(k, v) {
                    cinemasId.push(k);

                    cinemas.push(v[0].room.cinema.name);

                    var aux = [];
                    var ids = [];


                    $.each(v, function(k2, v2) {


                        ids.push(v2.id);
                        aux.push("Fecha: " + v2.day + " Sala: " + v2.room.name + " Horario: " + v2.hour);

                    })


                    optionsId[k] = ids;

                    options[k] = aux;


                })

                $('#options').empty();

                $('#options').append("<option value='' disabled selected>Select a Cinema</option>");

                for (i = 0; i < cinemas.length; i++) {


                    $('#options').append("<option value='" + cinemasId[i] + "'>" + cinemas[i] + "</option>");

                }

                $('#options').on('change', function() {


                    var selectValue = $(this).val();

                    $('#choices').empty();

                    // For each chocie in the selected option
                    for (i = 0; i < options[selectValue].length; i++) {

                        // Output choice in the target field
                        $('#choices').append("<option value='" + optionsId[selectValue][i] + "'>" + options[selectValue][i] + "</option>");

                    }

                });

            }
        });
        $('#show-movie').modal('show');
    });
</script>