<h1>Projet 2</h1>

<pre>
Gestionnaire utilisateur
API
JWT
etc...
</pre>

<h1>Projet 4</h1>

<pre>

Route (méthode POST):
https://localhost:8000/admin/pico/status
https://localhost:8000/admin/pico/vanne2/on
https://localhost:8000/admin/pico/pwm


Typescript (Angular):
this.http.post(
  'https://ton-site.fr/api/admin/pico/status',
  {
    vanne: 2,
    etat: true
  },
  {
    headers: {
      Authorization: `Bearer ${token}`
    }
  }
).subscribe(response =&gt; {
  console.log(response);
});


enlever vanne et état pour status sinon les laisser

</pre>
