<script type="text/javascript">
    $$btnBuy = document.querySelectorAll('#idMovie .event');

    $$btnBuy.forEach(e => e.addEventListener('click', function(e) {
        const $options = document.querySelector('#options');
        const $choices = document.querySelector('#choices');
        const $title = document.querySelector('#title');

        $choices.innerHTML = "";

        getMovieDataById(e.target.value)
            .then(movieData => {
                $title.innerHTML = movieData.title;
            });

        getMovieFunctions(e.target.value)
            .then(functionsPerCinema => {

                const cinemas = [];
                const options = {};

                Object.entries(functionsPerCinema).forEach(function([cinemaId, movieFunctions]) {

                    cinemas.push({
                        id: cinemaId,
                        name: movieFunctions[0].room.cinema.name
                    });

                    const movieOptions = movieFunctions.map(function(movieFunction) {
                        return {
                            id: movieFunction.id,
                            label: "Fecha: " + movieFunction.day + " Sala: " + movieFunction.room.name + " Horario: " + movieFunction.hour
                        }
                    })

                    options[cinemaId] = movieOptions;
                });

                $options.innerHTML = "";

                $options.innerHTML += `<option value="" disabled selected>Select a Cinema</option>`;

                for (i = 0; i < cinemas.length; i++) {
                    $options.innerHTML += `<option value="${cinemas[i].id}"> ${cinemas[i].name} </option>`;
                }

                $options.addEventListener('change', function() {

                    var selectValue = $options.value;
                    $choices.innerHTML = "";

                    // For each chocie in the selected option
                    for (i = 0; i < options[selectValue].length; i++) {
                        // Output choice in the target field
                        $choices.innerHTML += `<option value="${options[selectValue][i].id}">${options[selectValue][i].label}</option>`;
                    }

                });

            })

        async function getMovieDataById(idMovie) {
            const formData = new FormData();
            formData.append("selectValue", idMovie);

            return fetch("/TPFinalLab4/Movie/prueba", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
        }

        async function getMovieFunctions(idMovie) {
            const formData = new FormData();
            formData.append("selectValue", idMovie);
            return fetch("/TPFinalLab4/MovieFunction/prueba", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
        }
        $('#show-movie').modal('show');
    }));
</script>