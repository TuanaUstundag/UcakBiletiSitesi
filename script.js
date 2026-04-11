// --- STATİK VERİLER (Gelecekte PHP/Veritabanı ile değişecek) ---
const seatData = [
    { id: '1A', type: 'Cam', price: 1500, score: 2.3, comment: 'Sakin ama motor sesi çok.', occupied: false },
    { id: '1B', type: 'Koridor', price: 1000, score: null, comment: '', occupied: true }, // Dolu
    { id: '1C', type: 'Koridor', price: 1000, score: 3.1, comment: 'Ortalama.', occupied: false },
    { id: '1D', type: 'Cam', price: 1500, score: 4.4, comment: 'Geniş diz mesafesi.', occupied: false },

    { id: '2A', type: 'Cam', price: 1500, score: 4.3, comment: 'Çok güzel manzara.', occupied: false },
    { id: '2B', type: 'Koridor', price: 1000, score: null, comment: '', occupied: true }, // Dolu
    { id: '2C', type: 'Koridor', price: 1000, score: 4.1, comment: 'Temiz.', occupied: false },
    { id: '2D', type: 'Cam', price: 1500, score: 3.9, comment: 'Biraz dar.', occupied: false },

    { id: '3A', type: 'Cam', price: 1500, score: 1.7, comment: 'Koltuk bozuktu.', occupied: false },
    { id: '3B', type: 'Koridor', price: 1000, score: 4.5, comment: 'Mükemmel hizmet.', occupied: false },
    { id: '3C', type: 'Koridor', price: 1000, score: 3.3, comment: 'Eh işte.', occupied: false },
    { id: '3D', type: 'Cam', price: 1500, score: 3.5, comment: 'Geniş.', occupied: false },
    
    { id: '4A', type: 'Cam', price: 1500, score: 4.1, comment: 'Konforlu.', occupied: false },
    { id: '4B', type: 'Koridor', price: 1000, score: null, comment: '', occupied: true }, // Dolu
    { id: '4C', type: 'Koridor', price: 1000, score: 3.3, comment: 'Geniş koridor.', occupied: false },
    { id: '4D', type: 'Cam', price: 1500, score: 4.6, comment: 'Koridor tarafı her zaman iyidir.', occupied: false }, // Örnek koltuk
];

// --- ANA FONKSİYONLAR ---

const seatingPlanEl = document.getElementById('seatingPlan');
const bookingSummaryEl = document.getElementById('bookingSummary');
let currentSelectedSeat = null; // Sadece tek bir koltuk seçimine izin vermek için

// 1. Kabin Tasarımını Oluşturma (Initialization)
function initSeatingChart() {
    seatData.forEach((seat, index) => {
        // Koridor boşluğu kodu (Burası zaten sende var)
        if (index > 0 && index % 4 === 2) {
            const corridor = document.createElement('div');
            corridor.style.width = "40px";
            seatingPlanEl.appendChild(corridor);
        }

        // Koltuk elementini oluşturuyoruz
        const seatEl = document.createElement('div');
        seatEl.classList.add('seat');
        seatEl.dataset.id = seat.id;

        // --- EKLEYECEĞİN SATIR BURASI ---
        // Mouse ile üzerine gelince (hover) bilgi kutucuğu çıkmasını sağlar
        seatEl.title = `${seat.type} - ${seat.price} TL - ${seat.score || 0} Yıldız`;
        // --------------------------------

        // Geri kalan numara ve puan ekleme işlemleri (Burası sende var)
        const numSpan = document.createElement('span');
        numSpan.classList.add('seat-number');
        numSpan.textContent = seat.id;
        
        const scoreSpan = document.createElement('span');
        scoreSpan.classList.add('seat-score');
        scoreSpan.innerHTML = seat.score !== null ? `${seat.score} ⭐` : '&nbsp;';

        seatEl.appendChild(numSpan);
        seatEl.appendChild(scoreSpan);

        // ... kodun geri kalanı (if-else yapısı) aynen devam ediyor ...
        if (seat.occupied) {
            seatEl.classList.add('occupied');
        } else {
            seatEl.classList.add('empty');
            seatEl.addEventListener('click', () => handleSeatSelection(seatEl, seat));
        }

        seatingPlanEl.appendChild(seatEl);
    });
}

// 2. Renklendirme & Tıklama (Selection Logic)
function handleSeatSelection(seatEl, seat) {
    // Eğer aynı koltuğa tekrar tıklanırsa seçimi kaldır
    if (seatEl.classList.contains('selected')) {
        seatEl.classList.remove('selected');
        seatEl.classList.add('empty');
        clearSummary();
        currentSelectedSeat = null;
        return;
    }

    // Başka bir koltuk seçiliyse onun seçimini kaldır (Tek koltuk kuralı)
    if (currentSelectedSeat) {
        currentSelectedSeat.classList.remove('selected');
        currentSelectedSeat.classList.add('empty');
    }

    // Yeni koltuğu seç
    seatEl.classList.remove('empty');
    seatEl.classList.add('selected');
    currentSelectedSeat = seatEl;

    // Sağ taraftaki Özellik Gösterimini güncelle
    updateSummary(seat);
}

// 3. Özellik Gösterimi (Özet Paneli)
// (Mouse hover yerine tıklama daha kalıcıdır ama istersen mouseover ile de yapabiliriz)
function updateSummary(seat) {
    const starScore = seat.score ? `${seat.score} / 5.0 ⭐` : 'Puanlanmamış';
    
    bookingSummaryEl.innerHTML = `
        <div class="summary-card">
            <h3>Koltuk ${seat.id}</h3>
            <p><strong>Tür:</strong> ${seat.type}</p>
            <p><strong>Fiyat:</strong> ${seat.price} TL</p>
            <p><strong>Diz Mesafesi:</strong> Geniş</p>
            <p><strong>Yolcu Puanı:</strong> ${starScore}</p>
            <p><strong>Son Yorum:</strong> "${seat.comment}"</p>
        </div>
    `;
}

function clearSummary() {
    bookingSummaryEl.innerHTML = `<p>Henüz bir koltuk seçmediniz.</p>`;
}

// Sayfa yüklendiğinde koltukları çiz
initSeatingChart();