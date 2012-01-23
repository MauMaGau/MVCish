The model/controller/view setup is slightly irregular to the classic mvc approach:
Models are the objects of data, eg appointment.class contains the data of an appointment, usually pulled from the database, as well as handling inserts/updates/deletes
Controllers are the business logic, which gets/sets Model data and passes it to the view
Views are the most obvious break from traditional MVC. Rather than being called from the controller, they call the controller(s). Therefore the request is sent to the view, rather than the controller.
