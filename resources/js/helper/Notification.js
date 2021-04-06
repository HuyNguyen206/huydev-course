class Notification {
    notify(icon='success', title = 'Congratulation!', message = 'Successfully Done'){
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            // footer: '<a href>Why do I have this issue?</a>'
        })

    }

}

export default Notification = new Notification()
