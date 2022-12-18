window.lastAlarm = {};
function speakAlarm(message) {
  if (!app.alarm_going_off) {
    return;
  }
  var msg = new SpeechSynthesisUtterance();
  if (message) {
    msg.text = "Alarm going off for " + message;
  } else {
    msg.text = "Alarm going off.";
  }
  
  msg.lang = "en-US";

  speechSynthesis.cancel();
  speechSynthesis.speak(msg);
  msg.onend = function() {
    speakAlarm(message);
  };
}

function updateTime() {
  app.time = new Date();
  setTimeout(function() {
    updateTime();
  }, 1000);
}

$(function() {
  app = new Vue({
    el: "#app",
    data: {
      time: new Date(),
      alarm_going_off: false,
      alarms: []
    },
    mounted: function() {
      if (localStorage.alarms) {
        this.alarms = JSON.parse(localStorage.alarms);
      }
      setTimeout(updateTime, 1000);
    },
    methods: {
      saveAlarm: function() {
        new_alarm = {
          hour: $("#hour option:selected").text(),
          minute: parseInt($("#minute option:selected").text()),
          message: $("#alarm_message").val(),
          am_pm: $("#am_pm option:selected").text()
        };
        this.alarms.push(new_alarm);
        $("#alarm_message").val("");
      },
      stopAlarm: function() {
        this.alarm_going_off = false;
        speechSynthesis.cancel();
      },
      deleteAlarm: function(toRemove) {
        new_alarms = [];
        $.each(this.alarms, function(i, v) {
          if (i != toRemove) {
            new_alarms.push(v);
          }
        });
        this.alarms = new_alarms;
      }
    },
    watch: {
      alarms: function(newValue) {
        localStorage.setItem("alarms", JSON.stringify(newValue));
      },
      time: function(newValue) {
        if (this.alarm_going_off) {
          return;
        }
        $.each(this.alarms, function(i, alarm) {
          hours = app.time.getHours() % 12;
          if (hours == 0) {
            hours = 12;
          }
          am_pm = "PM";
          if (app.time.getHours() < 12) {
            am_pm = "AM";
          }
          if (
            parseInt(alarm.hour) == parseInt(hours) &&
            parseInt(alarm.minute) == app.time.getMinutes() &&
            alarm.am_pm == am_pm
          ) {
            if (JSON.stringify(alarm) != JSON.stringify(window.lastAlarm)) {
              app.alarm_going_off = true;
              window.lastAlarm = alarm;
              speakAlarm(alarm.message);
              return;
            }
          } else {
            window.lastAlarm = {};
          }
        });
      }
    }
  });
});