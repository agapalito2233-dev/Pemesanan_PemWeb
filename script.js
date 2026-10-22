function setError(inputId, errId, pesan) {
  document.getElementById(errId).textContent = pesan;
  document.getElementById(inputId).classList.toggle("invalid", pesan !== "");
}

function validasiForm() {
  var nama = document.getElementById("nama").value.trim();
  var menu = document.getElementById("menu").value;
  var jumlah = document.getElementById("jumlah").value;
  var valid = true;

  if (nama === "") {
    setError("nama", "errNama", "Nama wajib diisi.");
    valid = false;
  } else if (nama.length < 3) {
    setError("nama", "errNama", "Nama minimal 3 karakter.");
    valid = false;
  } else if (!/^[A-Za-z\s]+$/.test(nama)) {
    setError("nama", "errNama", "Nama hanya boleh berisi huruf.");
    valid = false;
  } else {
    setError("nama", "errNama", "");
  }

  if (menu === "") {
    setError("menu", "errMenu", "Silakan pilih menu.");
    valid = false;
  } else {
    setError("menu", "errMenu", "");
  }

  if (jumlah === "") {
    setError("jumlah", "errJumlah", "Jumlah wajib diisi.");
    valid = false;
  } else if (!Number.isInteger(Number(jumlah)) || Number(jumlah) < 1) {
    setError("jumlah", "errJumlah", "Jumlah harus bilangan bulat minimal 1.");
    valid = false;
  } else if (Number(jumlah) > 100) {
    setError("jumlah", "errJumlah", "Jumlah maksimal 100.");
    valid = false;
  } else {
    setError("jumlah", "errJumlah", "");
  }

  return valid;
}

document.getElementById("formPesan").addEventListener("submit", function (e) {
  if (!validasiForm()) {
    e.preventDefault();
    alert("Data belum valid. Periksa kembali isian Anda.");
  }
});
