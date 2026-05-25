<h1>Projet 2</h1>

<pre>

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