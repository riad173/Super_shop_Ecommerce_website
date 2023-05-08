const ctx = document.getElementById('myChart');
const earning = document.getElementById('earning');

  new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ['Vegetables', 'toy', 'Fruits', 'meat', 'snacks', 'oil'],
      datasets: [{
        label: 'Most product Sell',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      response: true,
    }
  });


  new Chart(earning, {
    type: 'bar',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [{
        label: 'Monthly Average Sell',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      response: true,
    }
  });