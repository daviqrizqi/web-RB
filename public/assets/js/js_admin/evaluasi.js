let currentRow = null;
let originalValues = [];
const originalData = {};
const rowStates = {};
// Array untuk menyimpan nilai awal baris sebelum di-edit
let currentIdRenaksi = null;
let currentIdPermasalahan = null;

//mengambil body tabel html
const tableBody = document.getElementById("table-body");

// Function to handle row approval

function initializeRowState(row) {
    const rowId = row.getAttribute("data-id");
    rowStates[rowId] = {
        isEditing: false,
        originalData: {},
        currentData: {},
    };

    // Store original data
    const cells = row.querySelectorAll("td");
    cells.forEach((cell) => {
        const columnName = cell.getAttribute("data-name");
        if (columnName) {
            rowStates[rowId].originalData[columnName] = cell.innerText.trim();
            rowStates[rowId].currentData[columnName] = cell.innerText.trim();
        }
    });
}

function updateRowDisplay(row) {
    const rowId = row.getAttribute("data-id");
    const state = rowStates[rowId];

    const cells = row.querySelectorAll("td");
    cells.forEach((cell) => {
        const columnName = cell.getAttribute("data-name");
        if (columnName && state.currentData[columnName] !== undefined) {
            if (state.isEditing) {
                cell.innerHTML = `<input type="text" name="${columnName}" value="${state.currentData[columnName]}">`;
            } else {
                cell.innerText = state.currentData[columnName];
            }
        }
    });

    // Update button states
    const editBtn = row.querySelector(".edit-btn");
    const rejectBtn = row.querySelector(".reject-btn");
    const reassignBtn = row.querySelector(".reassign-btn");

    if (state.isEditing) {
        editBtn.style.display = "block";
        editBtn.textContent = "Save";
        rejectBtn.textContent = "Cancel";
        reassignBtn.classList.remove("hidden");
    } else {
        editBtn.style.display = "none";
        rejectBtn.textContent = "Reject";
        reassignBtn.classList.add("hidden");
    }
}

// Fungsi untuk toggle Edit button dan mengedit baris
function toggleEditButton(row) {
    const rejectBtn = row.querySelector(".reject-btn");
    const editBtn = row.querySelector(".edit-btn");
    const reassignBtn = row.querySelector(".reassign-btn");
    const isEditable = row.classList.contains("editable");

    if (isEditable) {
        // If the row is already editable, save it and exit edit mode
        row.classList.remove("editable");
        rejectBtn.textContent = "Reject";
        editBtn.style.display = "none";
        reassignBtn.classList.add("hidden");
        storeOriginalRow(row); // Simpan data terbaru ke state
    } else {
        // Make the row editable
        row.classList.add("editable");
        rejectBtn.textContent = "Cancel";
        editBtn.style.display = "block";
        reassignBtn.classList.remove("hidden");
        makeRowEditable(row); // Buat baris menjadi dapat diedit
    }
}

// Fungsi untuk menyimpan baris yang sudah diedit
async function saveRow(row, idPermasalahan, idRenaksi) {
    const inputs = row.querySelectorAll("input");
    const rowData = {
        idPermasalahan: idPermasalahan,
        idRenaksi: idRenaksi,
    };

    // Ambil setiap input dan masukkan ke dalam objek rowData
    inputs.forEach((input) => {
        const columnName = input.name; // Ambil name dari input sebagai key
        const columnValue = input.value; // Ambil value dari input sebagai value
        rowData[columnName] = columnValue; // Simpan ke objek rowData
    });

    console.log(rowData);

    try {
        // Menggunakan Axios untuk mengirim data ke server
        const response = await axios.post(
            `${baseUrl}/update-by-admin`,
            rowData
        );

        // Tindakan setelah berhasil menyimpan data
        console.log("Data saved successfully:", response.data);
        const updatedData = response.data.updatedData;

        // Update each cell in the row with the new data from the server response
        for (const key in updatedData) {
            const cell = row.querySelector(`[data-name="${key}"]`);
            if (cell) {
                cell.innerText = updatedData[key]; // Set new value
            }
        }

        // Sembunyikan tombol edit dan kembalikan tampilan baris ke mode non-edit
        row.classList.remove("editable");
        const editBtn = row.querySelector(".edit-btn");
        const rejectBtn = row.querySelector(".reject-btn");
        const reassignBtn = row.querySelector(".reassign-btn");
        if (editBtn) editBtn.style.display = "none";
        if (rejectBtn) rejectBtn.textContent = "Reject"; // Ubah kembali ke teks "Reject"
        if (reassignBtn) reassignBtn.classList.add("hidden");

        // Simpan data terbaru ke dalam state setelah berhasil disimpan
        storeOriginalRow(row);
    } catch (error) {
        // Tindakan jika terjadi kesalahan
        console.error("Error saving data:", error);
        alert("Failed to save data. Please try again.");
    }
}

// Fungsi untuk membuat baris dapat diedit
function makeRowEditable(row) {
    const cells = row.querySelectorAll("[data-name]");
    cells.forEach((cell) => {
        const input = document.createElement("input");
        input.type = "text";
        input.name = cell.getAttribute("data-name");
        input.value = cell.innerText;
        cell.innerHTML = "";
        cell.appendChild(input);
    });
}

// Fungsi untuk menyimpan data asli baris
function storeOriginalRow(row) {
    const cells = row.querySelectorAll("[data-name]");
    cells.forEach((cell) => {
        const input = cell.querySelector("input");
        if (input) {
            cell.innerHTML = input.value;
        }
    });
}

// Fungsi untuk meng-handle aksi Reassign
function reassignRow(row, idRenaksi, idPermasalahan) {
    currentRow = row;
    currentIdRenaksi = idRenaksi;
    currentIdPermasalahan = idPermasalahan;
    document.getElementById("reassignModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("reassignModal").style.display = "none";
}

async function submitRevision() {
    const note = document.getElementById("revisionNote").value;
    if (note.trim() === "") {
        alert("Catatan revisi tidak boleh kosong.");
        return;
    }
    try {
        const response = await axios.post(`${baseUrl}/reject-by-admin`, {
            idRenaksi: currentIdRenaksi,
            idPermasalahan: currentIdPermasalahan,
            note: note,
        });

        console.log("Revision submitted successfully:", response.data);
        alert("Catatan revisi berhasil dikirim ke user.");

        // Update the row's status if needed
        const statusCell = currentRow.querySelector('[data-name="status"]');
        if (statusCell && response.data.data.statusReject.status) {
            statusCell.textContent = response.data.data.statusReject.status;
        }

        // Update button visibility
        updateButtonVisibility(currentRow);

        closeModal();
    } catch (error) {
        console.error("Error submitting revision:", error);
        alert("Gagal mengirim catatan revisi. Silakan coba lagi.");
    }
}

function updateButtonVisibility(row) {
    const statusCell = row.querySelector('[data-name="status"]');
    const approveBtn = row.querySelector(".approve-btn");
    const rejectBtn = row.querySelector(".reject-btn");
    const saveBtn = row.querySelector(".edit-btn");
    const reassignBtn = row.querySelector(".reassign-btn");

    if (!statusCell.textContent || statusCell.textContent.trim() === "") {
        // If status is null or empty, show both buttons
        approveBtn.style.display = "inline-block";
        rejectBtn.style.display = "inline-block";
    } else if (statusCell.textContent === "Approved") {
        // If status is 'Approved', hide both buttons
        approveBtn.style.display = "none";
        rejectBtn.style.display = "none";
    } else if (statusCell.textContent === "Pending") {
        // If status is 'Pending', show both buttons
        approveBtn.style.display = "inline-block";
        rejectBtn.style.display = "inline-block";
    } else if (statusCell.textContent === "Rejected") {
        // If status is 'Rejected', hide both buttons
        approveBtn.style.display = "none";
        rejectBtn.style.display = "none";
        saveBtn.style.display = "none";
        reassignBtn.style.display = "none";
    }
}

//load Cluster

async function loadClusters() {
    try {
        const response = await axios.get(`${baseUrl}/get-cluster`);
        const clusters = response.data.data;
        const selectElement = document.getElementById("cluster-select");
        selectElement.innerHTML = '<option value="">Pilih Cluster</option>';
        clusters.forEach((cluster) => {
            const option = document.createElement("option");
            option.value = cluster.id;
            option.textContent = cluster.cluster;
            option.id = cluster.cluster;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error loading clusters:", error);
    }
}

// async function saveRow(row, idPermasalahan, idRenaksi) {
//     const inputs = row.querySelectorAll("input");

//     const rowData = {
//         idPermasalahan: idPermasalahan, // Tambahkan idPermasalahan ke data yang dikirim
//         idRenaksi: idRenaksi, // Tambahkan idRenaksi ke data yang dikirim
//     };

//     // Ambil setiap input dan masukkan ke dalam objek rowData
//     inputs.forEach((input) => {
//         const columnName = input.name; // Ambil name dari input sebagai key
//         const columnValue = input.value; // Ambil value dari input sebagai value
//         rowData[columnName] = columnValue; // Simpan ke objek rowData
//     });

//     console.log(rowData);

//     try {
//         // Menggunakan Axios untuk mengirim data ke server
//         const response = await axios.post(
//             `${baseUrl}/update-by-admin`,
//             rowData
//         );

//         // Tindakan setelah berhasil menyimpan data
//         console.log("Data saved successfully:", response.data);

//         // Memperbarui tabel setelah menyimpan data
//         console.log(idTema);
//         await fetchData(IdTema); // Call to fetch updated data
//     } catch (error) {
//         // Tindakan jika terjadi kesalahan
//         console.error("Error saving data:", error);
//         alert("Failed to save data. Please try again.");
//     }
//     console.log();
// }

//load tema
async function loadTema(clusterId) {
    try {
        const params = {
            id: clusterId,
        };
        const response = await axios.get(`${baseUrl}/get-tema`, { params });
        const temas = response.data.data;
        const selectElement = document.getElementById("theme-select");
        selectElement.innerHTML = '<option value="">Pilih Tema</option>';
        temas.forEach((tema) => {
            const option = document.createElement("option");
            option.value = tema.id;
            option.textContent = tema.nama;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error loading tema:", error);
    }
}

// Function to download table data as Excel file

function downloadData() {
    const table = document.getElementById("evaluasiTable"); // Get table by its ID
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.writeFile(wb, "evaluasi_stunting_data.xlsx"); // Save file with a custom name
}

async function fetchData(id) {
    try {
        const response = await axios.get(`${baseUrl}/get-eval-rb`, {
            params: { id: idTema },
        });
        const data = response.data;
        console.log(data);
        updateTable(data.data);
    } catch (error) {
        console.error("Request failed:", error);
    }
}

function updateTable(data) {
    tableBody.innerHTML = ""; // Clear existing rows
    index = 0;
    data.forEach((items) => {
        let renaksi = items.all_related_data;
        console.log(renaksi);
        renaksi.forEach((item, index) => {
            const row = document.createElement("tr");
            row.classList.add("border", "table-row");

            row.innerHTML = `
                                <td class="py-2 px-4">${index + 1}</td>
                                 <td data-name="permasalahan" class="py-2 px-4">${
                                     items.pembuat.nama
                                 }</td>
                                <td data-name="permasalahan" class="py-2 px-4">${
                                    items.permasalahan
                                }</td>
                                <td data-name="sasaran" class="py-2 px-4">${
                                    items.sasaran
                                }</</td>
                                <td data-name="indikator" class="py-2 px-4">${
                                    items.indikator
                                }</td>
                                <td data-name="target" class="py-2 px-4">${
                                    items.target
                                }</td>
                                <td data-name="rencana_aksi" class="py-2 px-4">${
                                    item.rencana_aksi
                                }</td>
                                <td data-name="indikator_rencana_aksi" class="py-2 px-4">${
                                    item.indikator
                                }</td>
                                <td data-name="satuan" class="py-2 px-4">${
                                    item.satuan
                                }</td>
                                <td data-name="twI_target_penyelesaian" class="py-2 px-4">${
                                    item.target_penyelesaian.twI
                                }</td>
                                <td data-name="twII_target_penyelesaian" class="py-2 px-4">${
                                    item.target_penyelesaian.twII
                                }</td>
                                <td data-name="twIII_target_penyelesaian" class="py-2 px-4">${
                                    item.target_penyelesaian.twIII
                                }</td>
                                <td data-name="twIV_target_penyelesaian" class="py-2 px-4">${
                                    item.target_penyelesaian.twIV
                                }</td>
                                <td data-name="jumlah_target_penyelesaian" class="py-2 px-4">${
                                    item.target_penyelesaian.jumlah
                                }</td>
                                <td data-name="twI_realisasi_penyelesaian" class="py-2 px-4">${
                                    item.realisasi_penyelesaian.twI
                                }</td>
                                <td data-name="twII_realisasi_penyelesaian" class="py-2 px-4">${
                                    item.realisasi_penyelesaian.twII
                                }</td>
                                <td data-name="twIII_realisasi_penyelesaian" class="py-2 px-4">${
                                    item.realisasi_penyelesaian.twIII
                                }</td>
                                <td data-name="twIV_realisasi_penyelesaian" class="py-2 px-4">${
                                    item.realisasi_penyelesaian.twIV
                                }</td>
                                <td data-name="jumlah_realisasi_penyelesaian" class="py-2 px-4">${
                                    item.realisasi_penyelesaian.jumlah
                                }</td>
                                <td data-name="presentase_realisasi_penyelesaian" class="py-2 px-4">${
                                    item.realisasi_penyelesaian.presentase
                                }</td>
                                <td data-name="subjek" class="py-2 px-4">${
                                    item.target_penyelesaian.subjek
                                }</td>
                                <td data-name="twI_target_anggaran" class="py-2 px-4">${
                                    item.target_anggaran.twI
                                }</td>
                                <td data-name="twII_target_anggaran" class="py-2 px-4">${
                                    item.target_anggaran.twII
                                }</td>
                                <td data-name="twIII_target_anggaran" class="py-2 px-4">${
                                    item.target_anggaran.twIII
                                }</td>
                                <td data-name="twIV_target_anggaran" class="py-2 px-4">${
                                    item.target_anggaran.twIV
                                }</td>
                                <td data-name="jumlah_target_anggaran" class="py-2 px-4">${
                                    item.target_anggaran.jumlah
                                }</td>
                                <td data-name="twI_realisasi_anggaran" class="py-2 px-4">${
                                    item.realisasi_anggaran.twI
                                }</td>
                                <td data-name="twII_realisasi_anggaran" class="py-2 px-4">${
                                    item.realisasi_anggaran.twII
                                }</td>
                                <td data-name="twIII_realisasi_anggaran" class="py-2 px-4">${
                                    item.realisasi_anggaran.twIII
                                }</td>
                                <td data-name="twIV_realisasi_anggaran" class="py-2 px-4">${
                                    item.realisasi_anggaran.twIV
                                }</td>
                                <td data-name="jumlah_realisasi_anggaran" class="py-2 px-4">${
                                    item.realisasi_anggaran.jumlah
                                }</td>
                                <td data-name="presentase_realisasi_anggaran" class="py-2 px-4">${
                                    item.realisasi_anggaran.presentase
                                }</td>
                                <td data-name="koordinator" class="py-2 px-4">${
                                    item.koordinator
                                }</td>
                                <td data-name="pelaksana" class="py-2 px-4">${
                                    item.pelaksana
                                }</td>
                                <td data-name="status" class="status-cell py-2 px-4">${
                                    item.reject.status
                                }</td>

                                <td class="py-2 px-4 checkbox-center flex flex-wrap gap-2">
                                    <button data-id="${items.id}"
                                        class="bg-green-500 text-white w-full max-w-xs px-4 py-2 rounded hover:bg-green-600 approve-btn"
                                        onclick="approveRow(this.closest('tr'), '${
                                            item.id
                                        }')">Approve</button>
                                    <button data-id="${item.id}"
                                        class="bg-red-500 text-white w-full max-w-xs px-4 py-2 rounded hover:bg-red-600 reject-btn"
                                        onclick="toggleEditButton(this.closest('tr'))">Reject</button>
                                    <button data-id="${item.id}"
                                        class="bg-blue-500 text-white w-full max-w-xs px-4 py-2 rounded hover:bg-blue-600 edit-btn hidden"
                                        onclick="saveRow(this.closest('tr'), '${
                                            items.id
                                        }', '${item.id}')">Save</button>

                                    <button data-id="${item.id}"
                                        class="bg-yellow-500 text-white w-full max-w-xs px-4 py-2 rounded hover:bg-yellow-600 reassign-btn hidden"
                                        onclick="reassignRow(this.closest('tr'), '${
                                            item.id
                                        }', '${items.id}')">Reassign</button>
                                </td>
        `;

            tableBody.appendChild(row);
            updateButtonVisibility(row);
        });
    });
}

// function for load data in evaluasi
document.addEventListener("DOMContentLoaded", () => {
    let IdTema = null;
    // mengnalkan client view table

    // Function to fetch data from API

    // Function to update table with data

    loadClusters();

    document
        .getElementById("cluster-select")
        .addEventListener("change", function () {
            idCluster = this.value;
            var themeDropdown = document.getElementById("theme-dropdown");

            if (idCluster) {
                themeDropdown.classList.remove("hidden");

                loadTema(idCluster);
            } else {
                themeDropdown.classList.add("hidden");
                dropdownContainer.classList.add("hidden");
            }
        });

    document
        .getElementById("theme-select")
        .addEventListener("change", async function () {
            idTema = this.value;
            var themeDropdown = document.getElementById("refresContainer");

            if (idCluster) {
                themeDropdown.classList.remove("hidden");

                fetchData(idTema);
            } else {
                themeDropdown.classList.add("hidden");
                dropdownContainer.classList.add("hidden");
            }
        });
    document.getElementById("refreshButton").addEventListener("click", () => {
        fetchData(IdTema);
    });
});

async function approveRow(row, idRenaksi) {
    // Example: Display a confirmation alert
    if (confirm("Are you sure you want to approve this data?")) {
        try {
            // Menggunakan Axios untuk mengirim data ke server
            const response = await axios.post(`${baseUrl}/approve-by-admin`, {
                id: idRenaksi,
            });

            console.log(response.data);

            const statusCell = row.querySelector('[data-name="status"]');
            if (statusCell) {
                statusCell.innerText = response.data.data.statusReject.status; // Set nilai status baru
            }

            // Implement the logic to approve the data here
            alert("Data approved successfully.");

            // Optionally, you can hide or disable the buttons once approved
            updateButtonVisibility(row);
        } catch (error) {
            // Tindakan jika terjadi kesalahan
            console.error("Error saving data:", error);
            alert("Failed to save data. Please try again.");
        }
    }
}
