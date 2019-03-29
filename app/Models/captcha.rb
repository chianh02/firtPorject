class Captcha
  #require "RMagick"
  #include Magick

  def self.create_captcha(string,w=120,h=32)
    granite = Magick::ImageList.new
    granite.new_image(w,h, Magick::HatchFill.new('#eee', '#ddd',5))
    canvas = Magick::ImageList.new
    canvas.new_image(w, h, Magick::TextureFill.new(granite))
    text = Magick::Draw.new
    text.font("arial")
    text.font_weight("normal")
    text.pointsize = 21
    text.gravity = Magick::CenterGravity
    text.annotate(canvas, 0,0,2,2, string) {
      self.fill = '#eee'
    }
    text.annotate(canvas, 0,0,-1.5,-1.5, string) {
      self.fill = '#eee'
    }
    text.annotate(canvas, 0,0,0,0, string) {
      self.fill = '#888'
    }    
    canvas.write("public/assets/captcha.png")
  end
end