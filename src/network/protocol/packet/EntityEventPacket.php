<?php

class EntityEventPacket extends RakNetDataPacket{
	public $eid;
	public $event;
	
	const ENTITY_DAMAGE = 2;
	const ENTITY_DEAD = 3;
	/**
	 * Works only for player entities
	 */
	const ENTITY_COMPLETE_USING_ITEM = 9;
	const ENTITY_ANIM_10 = 10;
	
	public function __construct($eid = null, $event = null){
		$this->eid = $eid;
		$this->event = $event;
	}
	
	public function pid(){
		return ProtocolInfo::ENTITY_EVENT_PACKET;
	}
	
	public function decode(){
		$this->eid = $this->getInt();
		$this->event = $this->getByte();
	}
	
	public function encode(){
		$this->reset();
		$this->putInt($this->eid);
		$this->putByte($this->event);
	}
	
	public function eidsToLocal(Player $p){
		if(!$this->localEids){
			$this->localEids = true;
			$this->eid = $p->global2localEID[$this->eid] ?? false;
			if($this->eid === false) return false;
		}
		return true;
	}
	
	public function eidsToGlobal(Player $p){
		if($this->localEids){
			$this->localEids = false;
			$this->eid = $p->local2GlobalEID[$this->eid] ?? false;
			if($this->eid === false) return false;
		}
		return true;
	}
}
