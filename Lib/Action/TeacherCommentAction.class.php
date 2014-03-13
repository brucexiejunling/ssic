<?php
	class TeacherCommentAction extends Action{
		public function teacherLogin() {
			$this->display(teacherLogin);
		}

		public function teacherComment() {
			$this->display(teacherComment);
		}
	}
?>