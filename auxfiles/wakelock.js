    let wakeLock = null;

    function requestWakeLock() {
      if ('wakeLock' in navigator) {
        // Request a screen wake lock
        navigator.wakeLock.request('screen').then((lock) => {
          wakeLock = lock;
          console.log('Screen wake lock activated');
        }).catch((err) => {
          console.error('Failed to activate wake lock: ', err);
        });
      } else {
        console.warn('Wake Lock API is not supported.');
      }
    }

    function releaseWakeLock() {
      if (wakeLock !== null) {
        wakeLock.release().then(() => {
          console.log('Screen wake lock released');
        }).catch((err) => {
          console.error('Failed to release wake lock: ', err);
        });
        wakeLock = null;
      }
    }
