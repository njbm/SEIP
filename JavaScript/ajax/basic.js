function index() {

    fetch('https://jsonplaceholder.typicode.com/todos')
      .then(response => response.json())
     
        .then(result => {

            document.getElementById('todoList').innerHTML = '';

            let todoList = '';

            result.forEach(row => {
                todoList += `<tr>
                        <td>${row.id}</td>
                        <td>${row.title}</td>
                        <td>${row.completed}</td>
                        <td>
                            <a href="#" onclick="showDetails(${row.id})">Show</a>
                        </td>

                    </tr>`
            });

            document.getElementById('todoList').innerHTML = todoList;
        })
}

index();

document.getElementById('todoSubmit').addEventListener('click', function () {
    const title = document.getElementById('titleInput').value;

    const data = {
        'title': title,
        'isCompleted': false
    };

    fetch('https://jsonplaceholder.typicode.com/todos', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(res => {
            document.getElementById('titleInput').value = '';
            index();
        })

})

function showDetails(id) {
    show(id).then(data => {
        const index = document.getElementById('index');
        index.style.display = 'none';
        document.getElementById('show').innerHTML = data.title
    });
}

async function show(id) {
    const res = await fetch('https://jsonplaceholder.typicode.com/todos/' + id)
    return res.json();
}

document.getElementById('showIndex').addEventListener('click', function () {
    document.getElementById('index').style.display = '';
})


















